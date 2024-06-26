<!DOCTYPE html>
<html lang="en">

<head>
    <title>Picsel - New Game</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/newgame.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
    <?php if (isset($_GET['response']))
        if (json_decode($_GET['response'], true)['success']) { ?>
        <script defer src="./js/alert_success.js"></script>
    <?php } else { ?>
        <script defer src="./js/alert_error.js"></script>
    <?php }?>

</head>

<body>
    <header class="gametext">
        <a title="Go back" class="goback" href="/picsel/home.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
        <h1 class="title">New Game</h1>
    </header>
    <main>
        <form class="gameform" action="/picsel/db/new_game_check.php" method="post" enctype="multipart/form-data">
            <label hidden for="gametitleid">Title</label>
            <input class="gametitle" name="gametitle" id="gametitleid" type="text" placeholder="Game name" />
            <label hidden for="description">Description</label>
            <textarea class="description" id="description" name="description" placeholder="Description"></textarea>
            <label hidden for="gameimage">Image</label>
            <input class="image" name="gameimage" id="gameimage" type="file" accept="image/*" placeholder="Choose image"/>
            <fieldset class="tagsfield">
                <legend class="tagstitle">Choose tags for this game:</legend>
                <ul class="tagslist">
                    <?php foreach ($templateParams["tags"] as $tag): ?>
                    <li>
                        <label for="<?php echo $tag['name']; ?>"><?php echo $tag['name']; ?></label>
                        <input type="checkbox" id="<?php echo $tag['name']; ?>" name="tags[]" value="<?php echo $tag['name']; ?>" />
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