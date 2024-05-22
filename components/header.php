<header>
    <div class="profile" >
    <img src="assets/logo.svg" alt="" id="profileimageid"/>
    <p class="name">
        <span id="name"><?php echo ($templateParams['logged_user'])['name']; ?></span>
        <span id="tag">@<?php echo ($templateParams['logged_user'])['nickname']; ?></span>
    </p>
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
