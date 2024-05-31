<?php
require_once('./../bootstrap.php');
$id = $_GET['user_id'];
$followed = $dbh->getUserFromId($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> Profile </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/user_profile.css" />
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
                <img class="profileimage" src="../assets/logo.svg" alt="" />
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
        <!-- TODO: generare i post di questo user -->
    </main>
    <script type="text/javascript" src="/picsel/js/user_profile.js"></script>
</body>

</html>