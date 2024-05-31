<?php
include("account_utils.php");
sec_session_start();
if (isLoggedIn()) {
    require_once ('./bootstrap.php');
    $templateParams['title'] = "Picsel - Explore";
    $templateParams['posts'] = $dbh->getExplorePosts(10);
    $templateParams['followed'] = $dbh->getFollowedUsers();
    $templateParams['subscriptions'] = $dbh->getFollowedGames();
    $templateParams['logged_user'] = $dbh->getUserFromId($_SESSION['user_id']);
    
    require ("./template.php");
} else {
    echo 'Please log in to access content';
}
?>