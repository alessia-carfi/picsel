<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picsel - Post</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/post.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
    <script defer src="./js/post_interactions.js"></script>
  </head>

  <body>
    <a class="go-back" href="/picsel/home.php"><span class="fa-solid fa-arrow-left"></span></a>
    <main>
        <?php include_once 'bootstrap.php'; ?>
        <div class="post-and-comments">
            <?php $post = $dbh->getPostById($_GET['post_id']); ?>
            <?php include __DIR__ . '/components/post.php';?>
            <div class="comments">
              <form class="create-comment" action="./db/create_comment.php" method="post">
                <label hidden for="comment-text">Write a comment</label>
                <textarea class="comment-textarea" name="comment-text" id="comment-text" placeholder="Write a comment..."></textarea>
                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>" />
                <label hidden for="submit-comment">Submit</label>
                <input class="submit-comment" type="submit" name="submit-comment" id="submit-comment" value="Submit"/>
              </form>
              <hr />
              <?php $comments = $dbh->getCommentsByPostId($post['post_id']); ?>
              <?php if (count($comments) > 0): ?>
                <ul class="comments-list">
                <?php foreach ($comments as $comment): ?>
                  <li class="comment">
                    <p class="commenter">
                        <span class="username" name="username-comm" id="username-comm"><?php echo $dbh->getUserFromId($comment['user_id'])['name']?></span>
                    </p>
                    <p class="text"><?php echo $comment['text']?></p>
                  </li>
                  <hr />
                <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>
            </div>
        </div>
    </main>
  </body>
</html>