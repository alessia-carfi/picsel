<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Picsel - Settings</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/settings.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet" />
    <script defer src="../assets/fontawesome/js/solid.js"></script>
    <script defer src="../assets/fontawesome/js/fontawesome.js"></script>
    <script type="module" src="../js/settings.js"></script>
  </head>
  <?php
    include_once("../account_utils.php");
    include_once("../bootstrap.php");
    sec_session_start();
  ?>
  <body>
    <header>
        <h1>Settings</h1>
        <a class="go-back" href="/picsel/logged_user_feed.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
    </header>
    <main>
      <h2>Profile</h2>
        <form class="settings" id="settings-form" action="../db/update_profile.php" method="post" enctype="multipart/form-data">
            <label for="profile-picture">Change profile picture: </label>
            <input type="file" id="profile-picture" name="profile-picture" accept="image/png, image/jpeg" />
        
            <label for="name">Change name: </label>
            <input type="text" id="name" name="name" autocomplete="off" value="<?php echo $dbh -> getProfileName($_SESSION['user_id']); ?>"/>

            <label for="nickname">Change username: </label>
            <input type="text" id="nickname" name="nickname" autocomplete="off" value="<?php echo $_SESSION['username']; ?>"/>

            <label for="submit" hidden>Submit</label>
            <input type="submit" id="submit" name="submit" value="Submit" class="submit"/>
        </form>
    </main>
  </body>
</html>