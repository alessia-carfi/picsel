<?php
include("account_utils.php");
sec_session_start();
if (isLoggedIn()) {
    require_once ('./bootstrap.php');
    $templateParams['tags'] = $dbh->getAllTags(); 
    require (__DIR__ . "/components/newgame.php");
} else {
    echo 'Please log in to access content';
}
?>