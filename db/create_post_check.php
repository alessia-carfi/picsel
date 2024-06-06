<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $game = NULL;
    $content = NULL;
    $image = NULL;
    $response = NULL;
    if (isset($_POST['games'])) {
        $game = $_POST['games'];
    } 
    if (isset($_POST['postcontent'])) {
        $content = $_POST['postcontent'];
    }
    if (isset($_FILES["imageselect"]) 
        && $_FILES["imageselect"]["error"] === UPLOAD_ERR_OK) {
            $image = file_get_contents($_FILES['imageselect']['tmp_name']);
    }
    if ($game != NULL && ($content != NULL || $image != NULL) && $_FILES["imageselect"]["size"] <= MAX_PACKET) {
        $response = json_encode($dbh->addNewPost($content, $image, $game));
    }
    if ($response == NULL) {
        $response = json_encode(["success" => false]);
    }
    header("Location: ../createpost.php?response=$response");
}

?>