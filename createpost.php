<!DOCTYPE html>
<html lang="en">

<head>
    <title>Picsel - Create Post </title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/createpost.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <header class="posttext">
        <a title="Go back" class="goback" href="/picsel/home.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
        <h1 class="postp">Create Post</h1>
    </header>
    <main class="createpost">
        <?php include_once 'bootstrap.php'; ?>
        <form class="postform" action="/picsel/db/create_post_check.php" method="post" enctype="multipart/form-data">
            <label class="selectlabel" for="selectgame">Choose the Game:</label>
            <select class="selectgame" name="games" id="selectgame">
                <?php $options = $dbh -> getAllGames(); ?>
                <?php foreach ($options as $option): ?>
                    <option value="<?php echo $option['game_id']; ?>"><?php echo $option['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <label hidden for="postcontent">Post content</label>
            <textarea class="postcontentcl" name="postcontent" id="postcontent" placeholder="Text"></textarea>
            <label hidden for="imageselect">Select image</label>
            <input class="imageselect" name="imageselect" id="imageselect" type="file" accept="image/*" />
            <label hidden for="postbutton">Submit</label>
            <input type="submit" class="postbutton" name="postbutton" id="postbutton" value="Submit" />
        </form>
    </main>
</body>

</html>