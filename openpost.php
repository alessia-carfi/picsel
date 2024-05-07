<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Picsel</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/header.css" />
    <link rel="stylesheet" type="text/css" href="./css/post.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
    <script type="module" src="./js/main.js"></script>
  </head>

  <body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/nav.php'; ?>
    <main>
        <?php include_once 'bootstrap.php'; ?>
        <div class="post-and-comments">
            <?php $post = $dbh->getPostById($_GET['post_id']); ?>
            <?php include 'post.php';?>
            <div class="comment">
            <?php $comments = $dbh->getCommentsByPostId($post['post_id']); ?>
            <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                    <!-- TODO -->
                <p class="commenter">
                    <span class="username" name="username-comm" id="username-comm">Marcellino</span>
                    <span name="time" id="time">55m</span>
                </p>
                <p>Bellaaaaaaaa :3</p>
                <div class="comment-interactions">
                    <div class="interactions">
                        <label hidden for="upvote-comm">Upvote</label>
                        <i class="fa-solid fa-caret-up" name="upvote-comm" id="upvote-comm"></i>
                        <p>10</p>
                        <label hidden for="downvote-comm">Downvote</label>
                        <i class="fa-solid fa-caret-down" name="downvote" id="downvote"></i>
                    </div>
                    <i class="fa-solid fa-reply" id="reply" name="reply"></i>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <p>No comments yet.</p>
            <?php endif; ?>
            </div>
        </div>
    </main>
  </body>
</html>