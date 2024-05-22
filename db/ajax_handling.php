<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $method = $data['method'];
        $response = [];
        switch ($method) {
            case "votePost":
                $post_id = $data['post_id'];
                $type = $data['type'];
                $response = $dbh -> votePost($post_id, $type);
                break;
            case "savePost":
                $post_id = $data['post_id'];
                $response = $dbh->savePost($post_id);
                break;
            case "unsavePost":
                $post_id = $data['post_id'];
                $response = $dbh->unsavePost($post_id);
                break;
        }
        echo json_encode($response);
    }
?>