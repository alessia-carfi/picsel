<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['user_id'];

        $response = $dbh->getUserFromId($id);
        echo json_encode($response);
    }
?>