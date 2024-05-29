<?php
    require_once __DIR__ . '/../bootstrap.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];

        $response = $dbh -> checkSignupEmail($email);

        echo json_encode($response);
    }
?>