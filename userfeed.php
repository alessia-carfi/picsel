<?php
if (isLoggedIn()) {
    require_once __DIR__ . '/bootstrap.php';
    $templateParams['title'] = "Picsel - Home";
    $templateParams['posts'] = $dbh->getPostsByUserId(1);
    
    require __DIR__ . "/userprofile.php";
} else {
    echo 'Please log in to access content';
}
?>