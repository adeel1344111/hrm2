<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        $stmt = $pdo->query('SELECT * FROM did_weights ORDER BY id DESC');
        $dids = $stmt->fetchAll();
        
        $result = [];
        foreach ($dids as $did) {
            $result[] = [
                'id' => 'D' . $did['id'],
                'target_type' => $did['target_type'] ?? 'single_did',
                'target_values' => json_decode($did['target_values'] ?? '[]'),
                'count' => (float)($did['count'] ?? 1),
                'startDate' => $did['start_date'] ?? null,
                'endDate' => $did['end_date'] ?? null,
                'status' => $did['status'] ?? 'active'
            ];
        }
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $count = isset($data->count) ? (float)$data->count : 1;
    $startDate = !empty($data->startDate) ? $data->startDate : null;
    $endDate = !empty($data->endDate) ? $data->endDate : null;
    
    $target_type = isset($data->target_type) ? $data->target_type : 'multiple_did'; 
    $target_values = isset($data->target_values) && is_array($data->target_values) ? $data->target_values : [];

    if (empty($target_values) && !in_array($target_type, ['all_dids', 'all_campaigns'])) {
         echo json_encode(["error" => "No targets specified"]);
         exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO did_weights (target_type, target_values, count, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$target_type, json_encode($target_values), $count, $startDate, $endDate, 'active']);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->id)) {
        $real_id = (int) str_replace('D', '', $data->id);
        try {
            $stmt = $pdo->prepare('DELETE FROM did_weights WHERE id = ?');
            $stmt->execute([$real_id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
