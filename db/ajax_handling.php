<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $post_id = $data['post_id'];
        $type = $data['type'];

        $response = $dbh -> votePost($post_id, $type);

        echo json_encode($response);
    }
?>