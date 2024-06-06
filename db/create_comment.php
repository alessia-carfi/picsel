<?php
include __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comment-text'])) {
        $comment = $_POST['comment-text'];
        if ($comment != "") {
            $post = $_POST['post_id'];
            $dbh->createComment($comment, $post);
            echo "Comment uploaded successfully.";
        }
    } else {
        echo "Error uploading comment.";
    }
    header("Location: ../openpost.php?post_id=" . $_POST['post_id']);
}
