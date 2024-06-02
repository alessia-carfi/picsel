<?php
require_once('./../bootstrap.php');
$game_id = $_GET['game_id'];
$subscribed = $dbh->getGameFromId($game_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title> Profile </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/game_profile.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/regular.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <header>
        <a class="go-back" href="/picsel/home.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
    </header>
    <div class="profilewindow">
        <div class="profileinfo">
            <div class="profile">
                <?php if ($subscribed['image'] != NULL): ?>
                <img class="profileimage" src='data:image/PNG;base64,<?php echo base64_encode($subscribed['image']); ?>' alt="" />   
                <?php else:?>
                <img class="profileimage" src="../assets/logo.svg" alt="" />
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
            <button aria-label="subscribe" class="subscribebutton <?php echo $dbh->isUserSubscribed($game_id) ? 'subscribed' : 'notsubscribed' ?>" id="subscribebuttonid">
                <span class="subscribespan">Subscribe</span>
                <span class="unsubscribespan">Unsubscribe</span>
            </button>
        </div>
    </div>
    <main>
        <!-- TODO: generare i post di questo game -->
    </main>
    <script type="text/javascript" src="/picsel/js/game_profile.js"></script>
</body>

</html>