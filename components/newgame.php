<!DOCTYPE html>
<html lang="en">

<head>
    <title> New Game </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/newgame.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <header class="gametext">
        <a class="goback" href="/picsel/logged_user_feed.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
        <h1 class="title">New Game</h1>
    </header>
    <main>
        <form class="gameform">
            <label hidden for="gametitle">Title</label>
            <input class="gametitle" id="gametitleid" type="text" placeholder="Game name" />
            <label hidden for="description">Description</label>
            <textarea class="description" id="description" name="description" placeholder="Description"></textarea>
            <label hidden for="image">Image</label>
            <input class="image" id="image" type="file" accept="image/*" placeholder="Choose image"/>
            <label class="tagstitle">Choose tags for this game:</label>
            <fieldset class="tagsfield">
                <ul class="tagslist">
                    <?php foreach ($templateParams["tags"] as $tag): ?>
                        <!-- probabilmente sbagliato -->
                    <li>
                        <label for="<?php echo $tag['name']; ?>"><?php echo $tag['name']; ?></label>
                        <input type="checkbox" id="<?php echo $tag['name']; ?>" name="<?php echo $tag['name']; ?>" value="<?php echo $tag['name']; ?>" />
                    </li>
                    <?php endforeach; ?>
                </ul>
            </fieldset>
            <label hidden for="gamebuttonid">Submit</label>
            <input type="submit" class="gamebutton" id="gamebuttonid" value="Submit" />
        </form>
    </main>
</body>

</html>