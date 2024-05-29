<!DOCTYPE html>
<html lang="it">

<head>
    <title> Create Post </title>
    <meta charset="UTF-8" />
    <link href="css/createpost.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <div class="createpost">
        <p class="posttext">
        <a class="goback" href="/picsel/logged_user_feed.php" aria-label="Go back"><span class="fa-solid fa-arrow-left"></span></a>
            <span class="postp">Create Post</span>
        </p>
        <form class="postform">
            <label hidden for="postitleid">Title</label>
            <input class="posttitle" id="postitleid" type="text" placeholder="Title" />
            <div class="postimage">
                <label hidden for="posturlid">Image</label>
                <input class="posturl" id="posturlid" type="text" placeholder="URL" />
                <i class="fa-regular fa-image"></i>
                <label hidden for="imageselectid">Imageselect</label>
                <input class="imageselect" id="imageselectid" type="file" accept="image/png, image/jpeg" />
            </div>
            <label hidden for="postcontentid">Text</label>
            <textarea class="postcontentcl" id="postcontentid" placeholder="Text"></textarea>
            <label hidden for="postbuttonid">Submit</label>
            <input type="submit" class="postbutton" id="postbuttonid" value="Submit" />
        </form>
    </div>
</body>

</html>