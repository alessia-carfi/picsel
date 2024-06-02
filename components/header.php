<header>
    <div class="profile" id="profileid">
        <?php if ($templateParams['logged_user']['image'] != NULL) :?>
        <img src='data:image/PNG;base64,<?php echo base64_encode($templateParams['logged_user']['image']); ?>' alt="" id="profileimageid"/>
        <?php else:?>
        <img src="assets/logo.svg" alt="" id="profileimageid"/>
        <?php endif;?>
        <a class="name" href="./components/user_profile.php?user_id=<?php echo $templateParams['logged_user']['user_id']; ?>">
            <span id="name"><?php echo ($templateParams['logged_user'])['name']; ?></span>
            <span id="tag">@<?php echo ($templateParams['logged_user'])['nickname']; ?></span>
        </a>
    </div>
    <form id="searchid" class="search" action="/picsel/searched_posts.php" method="post">
        <button type="submit" aria-label="search">
            <span class="fa-solid fa-magnifying-glass"></span>
        </button>
        <label for="search-text">Search</label>
        <input
            type="text"
            name="search"
            id="search-text"
            placeholder="Search on Picsel" />
    </form>
    <img src="assets/logofull.svg" alt="Picsel logo" class="logo" />
    <div class="buttons">
        <button class="search-mobile" aria-label="search" id="search-mobile">
                <span class="fa-solid fa-magnifying-glass"></span>
        </button>
        <button id="burger" aria-label="menu">
            <span class="fa-solid fa-bars"></span>
        </button>
    </div>
</header>
