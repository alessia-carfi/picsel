<?php

require_once('./bootstrap.php');
require('components/signup_form.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    if ($dbh->register($name, $username, $email, $password, $confirmpassword)) {
        header('Location: ./index.php');
    } else {
        header('Location: ./signup.php?error=1');
    }
}
