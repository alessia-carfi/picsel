<?php
require_once('./../bootstrap.php');
$id = $_GET['user_id'];
$followed = $dbh->getUserFromId($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Picsel - Profile</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/user_profile.css" />
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
                <?php if ($followed['image'] != NULL): ?>
                <img alt="" class="profileimage" src='data:image/PNG;base64,<?php echo base64_encode($followed['image']); ?>' />   
                <?php else:?>
                <img alt="" class="profileimage" src="../assets/logo.svg" />
                <?php endif;?>
                <p class="profilename">
                    <span class="pr-name" id="pr-nameid"><?php echo $followed['name'] ?></span>
                    <span class="tagname" id="tagnameid">@<?php echo $followed['nickname'] ?></span>
                </p>
            </div>
            <?php
            if ($id != $_SESSION['user_id']):
            ?>
            <button aria-label="follow" class="followbutton <?php echo $dbh->isUserFollowed($id) ? 'followed' : 'notfollowed' ?>" id="followbuttonid">
                <span class="followspan">Follow</span>
                <span class="unfollowspan">Unfollow</span>
            </button>
            <?php endif; ?>
        </div>
    </div>
    <main>
        <?php
        $templateParams['posts'] = $dbh->getPostsByUserId($id);
        include __DIR__ . "/../generate_posts.php";
        ?>
    </main>
    <script type="text/javascript" src="/picsel/js/user_profile.js"></script>
</body>

</html>