<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // 1. Fetch all active Verification Officers
    // 2. See if they exist in the hidden_agents table
    try {
        $sql = "SELECT u.id, u.employee_id, u.name, 
                       CASE WHEN ha.employee_id IS NOT NULL THEN true ELSE false END as is_hidden
                FROM users u
                LEFT JOIN hidden_agents ha ON u.employee_id = ha.employee_id
                WHERE u.designation = 'Verification Officer' AND u.status = 'active'";
        $stmt = $pdo->query($sql);
        $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Convert integer/string booleans back to strict booleans for JSON
        foreach ($agents as &$agent) {
            $agent['is_hidden'] = (bool)$agent['is_hidden'];
        }
        
        echo json_encode($agents);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} elseif ($method === 'POST') {
    // Hide an agent
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->employee_id)) {
        try {
            $stmt = $pdo->prepare("INSERT IGNORE INTO hidden_agents (employee_id) VALUES (?)");
            $stmt->execute([$data->employee_id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "employee_id required"]);
    }
} elseif ($method === 'DELETE') {
    // Unhide an agent
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->employee_id)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM hidden_agents WHERE employee_id = ?");
            $stmt->execute([$data->employee_id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "employee_id required"]);
    }
}
?>
