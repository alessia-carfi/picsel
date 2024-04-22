<?php
include 'account_utils.php';
require_once('../bootstrap.php');

sec_session_start();
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($dbh->login($email, $password)) {
        echo 'Game on! You are logged in!';
        require('../userfeed.php');
    } else {
        header('Location: ./login.php?error=1');
    }
} else {
    echo 'Invalid Request!';
}
?>