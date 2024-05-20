<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $post_id = $data['post_id'];
        $type = $data['type'];
        $button = $data['button'];
        
        // TODO: controllare sul db se il post è stato votato o qui o nel db.
        /* $already_voted = $data['already_voted']; */
        $response = $dbh -> updatePostVoteCount($post_id, $type, $already_voted);

        echo json_encode($response);
    }
?>