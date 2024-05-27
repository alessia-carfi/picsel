<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nickname'])) {
        $newUsername = $_POST['nickname'];
        $dbh->setProfileNickname($newUsername);
        echo "Profile username uploaded successfully.";
    } else {
        echo "Error uploading profile username.";
    }
    if (isset($_POST['name'])) {
        $newName = $_POST['name'];
        $dbh->setProfileName($newName);
        echo "Profile name uploaded successfully.";
    } else {
        echo "Error uploading profile name.";
    }
    if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK) {
        $profilePic = file_get_contents($_FILES['profile-picture']['tmp_name']);
        $dbh->setProfileImage($profilePic);
        echo "Profile picture uploaded successfully.";
    } else {
        echo "Error uploading profile picture.";
    }
    header("Location: ../components/settings.php");
}
