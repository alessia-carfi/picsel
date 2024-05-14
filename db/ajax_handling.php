<?php
require_once("./database.php");

if ($_POST['method'] == 'votePost') {
    // $data = json_decode(file_get_contents('php://input'), true);
    // $updated_rows = $dbh->votePost($data['post_id'], $data['type'], $data['already_voted']);
    $updatedRows = "LE BANANE";
    echo json_encode(['message' => 'Update successful', 'updatedRows' => $updatedRows]);
}

?>