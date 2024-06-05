<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = NULL;
    $desc = NULL;
    $user_id = $_SESSION['user_id'];
    $image = NULL;
    $tags = NULL;
    $response = NULL;
    if (isset($_POST["gametitle"])) {
        $name = $_POST["gametitle"];
    }
    if (isset($_POST['description'])) {
        $desc = $_POST["description"];
    }
    if (isset($_FILES["gameimage"]) && $_FILES["gameimage"]["error"] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['gameimage']['tmp_name']);
    }
    if (isset($_POST['tags'])) {
        $tags = $_POST['tags'];
    }
    if ($name != NULL && $desc != NULL && $image != NULL && $tags != NULL) {
        $response = json_encode($dbh->addNewGame($name, $desc, $user_id, $image, $tags));
    }
    if ($response == NULL) {
        $response = json_encode(["success" => false]);
    }
    header("Location: ../create_newgame.php?response=$response");
}

?>