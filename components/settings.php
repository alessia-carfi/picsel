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
    <script type="module" src="../js/main.js"></script>
  </head>

  <body>
    <header>
        <h1>Settings</h1>
        <a class="go-back" href="/picsel/logged_user_feed.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
    </header>
    <main>
      <h2>Profile</h2>
        <ul class="settings-list">
            <li>
                <label for="profile-picture">Change profile picture: </label>
                <input type="file" accept="image/png, image/jpeg" />
            </li>

            <li>
                <label for="username">Change username: </label>
                <input type="text" />
            </li>
            <li>
                <label for="submit" hidden>Submit</label>
                <input type="submit" />
            </li>
        </ul>
        
    </main>
  </body>
</html>