<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nickname']) && trim($_POST['nickname']) != "") {
        $newUsername = $_POST['nickname'];
        $dbh->setProfileNickname($newUsername);
    }
    if (isset($_POST['name']) && trim($_POST['name']) != "") {
        $newName = $_POST['name'];
        $dbh->setProfileName($newName);
    }
    if (isset($_FILES['profile-picture']) 
        && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK 
        && $_FILES["profile-picture"]["size"] <= MAX_PACKET) {
        $profilePic = file_get_contents($_FILES['profile-picture']['tmp_name']);
        $dbh->setProfileImage($profilePic);
    }
    header("Location: ../components/settings.php");
}
