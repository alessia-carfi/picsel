<?php
require_once('./../bootstrap.php');
$game_id = $_GET['game_id'];
$subscribed = $dbh->getGameFromId($game_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Picsel - Game</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/game_profile.css" />
    <link rel="stylesheet" type="text/css" href="../css/post.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/regular.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <script defer src="/picsel/js/post_interactions.js"></script>
</head>

<body>
    <header>
        <a title="Go back" class="go-back" href="/picsel/home.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
    </header>
    <div class="profilewindow">
        <div class="profileinfo">
            <div class="profile">
                <?php if ($subscribed['image'] != NULL): ?>
                <img class="profileimage" alt="" src='data:image/PNG;base64,<?php echo base64_encode($subscribed['image']); ?>' />   
                <?php else:?>
                <img class="profileimage" alt="" src="../assets/logo.svg" />
                <?php endif;?>
                <p class="profilename">
                    <?php echo $subscribed['name'] ?>
                </p>
            </div>
            <p class="description">
                <?php echo $subscribed['description'] ?>
            </p>
            <ul class="tags">
                <?php foreach ($dbh->getAllTagsGame($game_id) as $tag) : ?>
                    <li>
                        <p><?php echo $tag['name'] ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button aria-label="subscribe" class="<?php echo $dbh->isUserSubscribed($game_id) ? 'subscribed' : 'notsubscribed' ?>" id="subscribebuttonid">
                <span class="subscribespan">Subscribe</span>
                <span class="unsubscribespan">Unsubscribe</span>
            </button>
        </div>
    </div>
    <main>
        <?php
        $templateParams['posts'] = $dbh->getPostsByGameId($game_id);
        include __DIR__ . "/../generate_posts.php";
        ?>
    </main>
    <script type="text/javascript" src="/picsel/js/game_profile.js"></script>
</body>

</html>