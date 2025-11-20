<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);
    
    $playerName = $input['playerName'] ?? '';
    $score = $input['score'] ?? 0;
    $stage = $input['stage'] ?? 1;
    $stageName = $input['stageName'] ?? 'Stage 1';
    
    if (empty($playerName)) {
        echo json_encode(['success' => false, 'error' => 'Player name is required']);
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO scores (player_name, score, stage, stage_name) VALUES (?, ?, ?, ?)");
        $stmt->execute([$playerName, $score, $stage, $stageName]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Score submitted successfully',
            'id' => $pdo->lastInsertId()
        ]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Only POST method allowed']);
}
?>