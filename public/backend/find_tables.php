<?php
require 'backend/db.php';

try {
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach($tables as $t) {
        if (strpos($t, 'log') !== false || strpos($t, 'submission') !== false || strpos($t, 'record') !== false || strpos($t, 'agent') !== false || strpos($t, 'user') !== false) {
             echo "Found potential table: " . $t . "\n";
             $cols = $pdo->query("SHOW COLUMNS FROM `$t`")->fetchAll(PDO::FETCH_COLUMN);
             echo "Columns: " . implode(", ", $cols) . "\n\n";
        }
    }
} catch (Exception $e) {
    echo "Error: ". $e->getMessage();
}
?>
