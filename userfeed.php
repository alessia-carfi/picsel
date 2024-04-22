<?php
require_once('./bootstrap.php');
$templateParams['title'] = "Picsel - Home";
$templateParams['posts'] = $dbh->getPostsByUserId(1);

require("./userprofile.php");
?>