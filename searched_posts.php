<?php
include("account_utils.php");
sec_session_start();
if (isLoggedIn()) {
    require_once ('./bootstrap.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['search'])) {
            $searchText = $_POST['search'];
            $templateParams['title'] = "Picsel - Searched Posts";
            $templateParams['posts'] = $dbh->getPostsFromSearch($searchText);
            $templateParams['followed'] = $dbh->getFollowedUsers();
            $templateParams['subscriptions'] = $dbh->getFollowedGames();
            $templateParams['logged_user'] = $dbh->getUserFromId($_SESSION['user_id']);
            
            require ("./template.php");
        }
    } else {
        echo "No post found";
    }
} else {
    echo 'Please log in to access content';
}
?>