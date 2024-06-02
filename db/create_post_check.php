<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $game = NULL;
    $content = NULL;
    $image = NULL;
    if (isset($_POST['games'])) {
        $game = $_POST['games'];
    }
    if (isset($_POST['postcontent'])) {
        $content = $_POST['postcontent'];
    }
    if (isset($_FILES["imageselect"]) && $_FILES["imageselect"]["error"] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['imageselect']['tmp_name']); 
    }
    if ($game != NULL) {
        $dbh->addNewPost($content, $image, $game);
    }
    header("Location: ../createpost.php ");
}

?>