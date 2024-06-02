<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = "";
    $desc = "";
    $user_id = $_SESSION['user_id'];
    $image = "";
    $tags = [];
    if (isset($_POST["gametitle"])) {
        $name = $_POST["gametitle"];
    } else {
        "No game name provided";
    }
    if (isset($_POST['description'])) {
        $desc = $_POST["description"];
    } else {
        "No description provided";
    }
    if (isset($_FILES["gameimage"]) && $_FILES["gameimage"]["error"] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['gameimage']['tmp_name']);
    } else {
        "Error uploading game image or no image provided";
    }
    if (isset($_POST['tags'])) {
        $tags = $_POST['tags'];
    } else {
        echo "Please select at least one tag";
    }
    $dbh->addNewGame($name, $desc, $user_id, $image, $tags);
    header("Location: ../create_newgame.php");
}

?>