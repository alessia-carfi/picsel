<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $game_id = $data['id'];
        $response = $response = $dbh -> followingGame($game_id);
       
        echo json_encode($response);
    }
    
?>
