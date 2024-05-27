<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Picsel</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/header.css" />
    <link rel="stylesheet" type="text/css" href="./css/post.css" />
    <link rel="stylesheet" type="text/css" href="./css/sidemenu.css" />
    <link rel="stylesheet" type="text/css" href="./css/inbox.css" />
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
    <?php include 'components/options.php'; ?>
    <?php include 'components/sidemenu.php'; ?>
    <main>
    <?php include 'generate_posts.php'; ?>
    <?php include './db/ajax_handling.php'; ?>
    </main>
  </body>

</html>