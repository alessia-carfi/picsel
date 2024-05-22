<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Picsel</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/post.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
    <script type="module" src="./js/main.js"></script>
  </head>

  <body>
    <a class="go-back" href="/picsel/logged_user_feed.php"><span class="fa-solid fa-arrow-left"></span></a>
    <main>
        <?php include_once 'bootstrap.php'; ?>
        <div class="post-and-comments">
            <?php $post = $dbh->getPostById($_GET['post_id']); ?>
            <?php include __DIR__ . '/components/post.php';?>
            <div class="comment">
            <?php $comments = $dbh->getCommentsByPostId($post['post_id']); ?>
            <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                    <!-- TODO -->
                <p class="commenter">
                    <span class="username" name="username-comm" id="username-comm"><?php echo $dbh->getUserFromId($comment['user_id'])?></span>
                    <span name="time" id="time">55m</span>
                </p>
                <p><?php echo $comment['text']?></p>
                <div class="comment-interactions">
                    <div class="interactions">
                        <label hidden for="upvote-comm">Upvote</label>
                        <span class="fa-solid fa-caret-up" name="upvote-comm" id="upvote-comm"></span>
                        <p>10</p>
                        <label hidden for="downvote-comm">Downvote</label>
                        <span class="fa-solid fa-caret-down" name="downvote" id="downvote"></span>
                    </div>
                    <span class="fa-solid fa-reply" id="reply" name="reply"></span>
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