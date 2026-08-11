<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require 'db.php';

$type = $_GET['type'] ?? 'today'; // 'today', 'monthly', 'lowest'

// Since we cannot inspect the exact DB schema (access denied locally),
// we wrap the query in try-catch and provide a fallback that matches the requested UI data structure.
// The user will need to adjust the SQL query below to match their exact tables.

try {
    $timeFilter = "";
    $timeFilterBase = "";
    if ($type === 'monthly' || $type === 'lowest') {
        $timeFilterBase = "YEAR({ALIAS}.created_at) = YEAR(DATE_SUB(NOW(), INTERVAL 6 HOUR)) AND MONTH({ALIAS}.created_at) = MONTH(DATE_SUB(NOW(), INTERVAL 6 HOUR))";
    } elseif ($type === 'today' || $type === 'lowest_today') {
        $timeFilterBase = "DATE(DATE_SUB({ALIAS}.created_at, INTERVAL 6 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 6 HOUR))";
    }

    $orderBy = ($type === 'lowest') ? 'ASC' : 'DESC';

    // Helper to get time filter with specific alias
    $getTimeFilter = function($alias) use ($timeFilterBase) {
        return $timeFilterBase ? "AND " . str_replace('{ALIAS}', $alias, $timeFilterBase) : "";
    };

    // Query specifically for Verification officers who are active
    if ($type === 'summary') {
        // Workdays
        $workdays = 0;
        $today = time();
        $firstDay = strtotime(date('Y-m-01'));
        for ($i = $firstDay; $i <= $today; $i += 86400) {
            $dayOfWeek = date('N', $i);
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
                $workdays++;
            }
        }
        $workdays = max(1, $workdays);

        // Alias for summary queries
        $tfMonth = "AND YEAR(v.created_at) = YEAR(DATE_SUB(NOW(), INTERVAL 6 HOUR)) AND MONTH(v.created_at) = MONTH(DATE_SUB(NOW(), INTERVAL 6 HOUR))";
        $tfToday = "AND DATE(DATE_SUB(v.created_at, INTERVAL 6 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 6 HOUR))";

        // Total Month with refined multiplier logic
        $sqlMonth = "SELECT SUM(
                        COALESCE(
                            (SELECT dw.count FROM did_weights dw 
                             WHERE (
                                (dw.target_type = 'multiple_did' AND JSON_CONTAINS(dw.target_values, JSON_QUOTE(v.did))) OR
                                (dw.target_type = 'multiple_campaign' AND JSON_CONTAINS(dw.target_values, JSON_QUOTE(v.campaign))) OR
                                (dw.target_type = 'all_dids' AND v.did IS NOT NULL AND v.did != '') OR
                                (dw.target_type = 'all_campaigns' AND v.campaign IS NOT NULL AND v.campaign != '')
                             )
                             AND (dw.start_date IS NULL OR dw.start_date <= DATE(v.created_at))
                             AND (dw.end_date IS NULL OR dw.end_date >= DATE(v.created_at))
                             AND dw.status = 'active'
                             ORDER BY dw.start_date DESC
                             LIMIT 1),
                            1
                        )
                     ) as total
                     FROM verification_submissions v
                     JOIN users u ON u.employee_id = v.employee_id
                     WHERE u.designation = 'Verification Officer' 
                     $tfMonth";
        $stmt = $pdo->query($sqlMonth);
        $totalMonth = (float) $stmt->fetchColumn();

     $sqlToday = "SELECT SUM(
                COALESCE(
                    (SELECT dw.count FROM did_weights dw 
                     WHERE (
                        (dw.target_type = 'multiple_did' AND JSON_CONTAINS(dw.target_values, JSON_QUOTE(v.did))) OR
                        (dw.target_type = 'multiple_campaign' AND JSON_CONTAINS(dw.target_values, JSON_QUOTE(v.campaign))) OR
                        (dw.target_type = 'all_dids' AND v.did IS NOT NULL AND v.did != '') OR
                        (dw.target_type = 'all_campaigns' AND v.campaign IS NOT NULL AND v.campaign != '')
                     )
                     AND (dw.start_date IS NULL OR dw.start_date <= DATE(v.created_at))
                     AND (dw.end_date IS NULL OR dw.end_date >= DATE(v.created_at))
                     AND dw.status = 'active'
                     ORDER BY dw.start_date DESC
                     LIMIT 1),
                    1
                )
             ) as total
             FROM verification_submissions v
             JOIN users u ON u.employee_id = v.employee_id
             WHERE u.designation = 'Verification Officer'
             AND v.campaign != 'Medicare'
             $tfToday";

$stmt = $pdo->query($sqlToday);
$totalToday = (float) $stmt->fetchColumn();

        echo json_encode([
            'totalMonth' => (float)$totalMonth,
            'totalToday' => (float)$totalToday,
            'workdays' => $workdays
        ]);
        exit;
    }

    $tfOuter = $getTimeFilter('v');
    $tfSub = $getTimeFilter('v_sub');

    // Base query for counts with complex multiplier logic
    $countSubquery = "(SELECT COALESCE(SUM(COALESCE(
                        (SELECT dw.count FROM did_weights dw 
                          WHERE (
                             (dw.target_type = 'multiple_did' AND JSON_CONTAINS(dw.target_values, JSON_QUOTE(v_sub.did))) OR
                             (dw.target_type = 'multiple_campaign' AND JSON_CONTAINS(dw.target_values, JSON_QUOTE(v_sub.campaign))) OR
                             (dw.target_type = 'all_dids' AND v_sub.did IS NOT NULL AND v_sub.did != '') OR
                             (dw.target_type = 'all_campaigns' AND v_sub.campaign IS NOT NULL AND v_sub.campaign != '')
                          )
                          AND (dw.start_date IS NULL OR dw.start_date <= DATE(v_sub.created_at))
                          AND (dw.end_date IS NULL OR dw.end_date >= DATE(v_sub.created_at))
                          AND dw.status = 'active'
                          ORDER BY dw.start_date DESC
                         LIMIT 1),
                        1
                    )), 0)
                    FROM verification_submissions v_sub
                    WHERE v_sub.employee_id = u.employee_id $tfSub)";

    $sql = "SELECT 
                u.name, 
                u.profile_picture,
                $countSubquery as count,
                COUNT(DISTINCT DATE(v.created_at)) as days_worked
            FROM users u
            LEFT JOIN verification_submissions v ON u.employee_id = v.employee_id $tfOuter
            WHERE u.designation = 'Verification Officer'
            AND u.employee_id NOT IN (SELECT employee_id FROM hidden_agents)
            GROUP BY u.id, u.name
            HAVING count > 0
            ORDER BY count $orderBy, MAX(v.created_at) ASC";

    if ($type === 'lowest' || $type === 'lowest_today') {
      $sql = "SELECT 
                  u.name, 
                  u.profile_picture,
                  $countSubquery as count,
                  COUNT(DISTINCT DATE(v.created_at)) as days_worked
              FROM users u
              LEFT JOIN verification_submissions v ON u.employee_id = v.employee_id $tfOuter
              WHERE u.designation = 'Verification Officer' AND u.status = 'active'
              AND u.employee_id NOT IN (SELECT employee_id FROM hidden_agents)
              GROUP BY u.id, u.name
              HAVING count > 0
              ORDER BY count ASC, MAX(v.created_at) DESC";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    // Calculate working days in the current month up to today (Monday to Friday)
    // Only used to ensure we have a baseline if needed, but per request LPD uses agent's actual submitted days
    $workdays = 0;
    $today = time();
    $firstDay = strtotime(date('Y-m-01'));
    
    for ($i = $firstDay; $i <= $today; $i += 86400) {
        $dayOfWeek = date('N', $i);
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
            $workdays++;
        }
    }
    $workdays = max(1, $workdays); // Prevent division by zero

    // Add ranking, Days Worked, and LPD
    $performers = [];
    $rank = 1;
    foreach ($results as $r) {
        $count = (float) $r['count'];
        $daysWorked = (int) ($r['days_worked'] ?? 0);
        
        $item = [
            "id" => $rank, // Generic ID for front-end rendering
            "name" => $r['name'] ?? 'Unknown',
            "profile_picture" => $r['profile_picture'] ?? null,
            "count" => $count,
            "rank" => $rank
        ];
        
        if ($type === 'monthly' || $type === 'lowest') {
            $item["daysWorked"] = $daysWorked;
            $item["lpd"] = ($workdays > 0) ? round($count / $workdays, 2) : 0;
        }
        
        $performers[] = $item;
        $rank++;
    }

    echo json_encode($performers);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
}
