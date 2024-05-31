<header>
    <div class="profile" >
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
    <div class="search">
    <span class="fa-solid fa-magnifying-glass"></span>
    <label for="search">Search</label>
    <input
        type="text"
        name="search"
        id="search"
        placeholder="Search on Picsel" />
    </div>
    <img src="assets/logofull.svg" alt="Picsel logo" class="logo" />
    <button id="burger"><span class="fa-solid fa-bars"></span></button>
</header>
