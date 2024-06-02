<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $game = 0;
    $content = "";
    $image = "";
    if (isset($_POST['games'])) {
        $game = $_POST['games'];
    } else {
        echo "No game selected";
    }
    if (isset($_POST['postcontent'])) {
        $content = $_POST['postcontent'];
    } else {
        echo "Please write something";
    }
    if (isset($_FILES["imageselect"]) && $_FILES["imageselect"]["error"] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['imageselect']['tmp_name']); 
    } else {
        $image = NULL;
    }
    $dbh->addNewPost($content, $image, $game);
    header("Location: ../createpost.php ");
}

?>