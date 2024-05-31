<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $method = $data['method'];
        $id = $data['id'];
        $response = [];
        switch ($method) {
            case "follow":
                $response = $dbh -> followingUser($id);
                break;
            case "unfollow":
                $response = $dbh->unfollowUser($id);
                break;
        }
        echo json_encode($response);
    }
    
?>
