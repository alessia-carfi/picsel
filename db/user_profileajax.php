<?php
    require_once __DIR__ . '/../bootstrap.php';
    sec_session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $response = $dbh->getUserFromId($id);
        echo json_encode($response);
    }
?>