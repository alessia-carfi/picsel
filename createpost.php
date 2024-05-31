<!DOCTYPE html>
<html lang="it">

<head>
    <title>Picsel - Create Post </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/createpost.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <header class="posttext">
        <a class="goback" href="/picsel/home.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
        <h1 class="postp">Create Post</h1>
    </header>
    <main class="createpost">
        <?php include_once 'bootstrap.php'; ?>
        <form class="postform">
        <label class="selectlabel" for="games">Choose the Game:</label>
        <select class="selectgame" name="games" id="selectgame">
            <?php $options = $dbh -> getFollowedGames(); ?>
            <?php foreach ($options as $option): ?>
                <option value="<?php echo $option['name']; ?>"><?php echo $option['name']; ?></option>
            <?php endforeach; ?>
        </select>
            <label hidden for="postitle">Post title</label>
            <input class="posttitle" name="postitle" id="postitleid" type="text" placeholder="Title" />
            <label hidden for="postcontent">Post content</label>
            <textarea class="postcontentcl" name="postcontent" id="postcontentid" placeholder="Text"></textarea>
            <label hidden for="imageselect">Select image</label>
            <input class="imageselect" name="imageselect" id="imageselectid" type="file" accept="image/*" />
            <label hidden for="postbutton">Submit</label>
            <input type="submit" class="postbutton" name="postbutton" id="postbuttonid" value="Submit" />
        </form>
    </main>
</body>

</html>