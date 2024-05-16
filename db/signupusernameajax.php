<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];

        $response = $dbh -> checkSignupUsername($username);

        echo json_encode($response);
    }
?>