<?php
include 'account_utils.php';

sec_session_start();
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($dbh->login($email, $password)) {
        session_write_close();
        header("Location: userfeed.php");
        exit();
    } else {
        header('Location: ./login.php?error=1');
    }
} else {
    echo 'Invalid Request! Insert 500L to continue.';
}
?>