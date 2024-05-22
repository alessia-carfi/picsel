<?php
include("account_utils.php");
sec_session_start();
if (isLoggedIn()) {
    require_once ('./bootstrap.php');
    $templateParams['title'] = "Picsel - Home";
    $templateParams['posts'] = $dbh->getPostsByUserIdWithLiked($_SESSION['user_id']);
    $templateParams['followed'] = $dbh->getFollowedUsers();
    $templateParams['subscriptions'] = $dbh->getFollowedGames();
    
    require ("./template.php");
} else {
    echo 'Please log in to access content';
}
?>