<?php
include("account_utils.php");
sec_session_start();
if (isLoggedIn()) {
    require_once ('./bootstrap.php');
    $templateParams['title'] = "Picsel - Home";
    $templateParams['posts'] = $dbh->getPostsByUserId(1);
    
    require ("./userprofile.php");
} else {
    echo 'Please log in to access content';
}
?>