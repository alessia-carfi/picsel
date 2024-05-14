<?php

require_once('./bootstrap.php');
require('components/signup_form.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirmpassword'])) {
        if ($_POST['password'] !== $_POST['confirmpassword']) {
            die('Passwords do not match');
        }
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        if ($dbh->register($name, $username, $email, $password, $confirmpassword)) {
            header('Location: ./signupsuccess.php');
        } else {
            header('Location: ./signup.php?error=1');
        }
    } else {
        echo 'Invalid Request! Insert 500L to continue.';
    }
}
