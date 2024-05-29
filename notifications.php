<?php
include("account_utils.php");
sec_session_start();
if (isLoggedIn()) {
    require_once ('./bootstrap.php');
    $templateParams['title'] = "Picsel - Notifications";
    $templateParams['notifs'] = $dbh->getNotifications();
    $templateParams['followed'] = $dbh->getFollowedUsers();
    $templateParams['subscriptions'] = $dbh->getFollowedGames();
    $templateParams['logged_user'] = $dbh->getUserFromId($_SESSION['user_id']);
    
    require ("./notifs_full_page.php");
} else {
    echo 'Please log in to access content';
}
?>