<div class="shadow" id="shadowid">
    <div class="sidemenu" id="sidemenuid">
        <div class="top-sidemenu"  id="top-sidemenu" style="display: none">
            <div class=profile-mobile>
                <?php if ($templateParams['logged_user']['image'] != NULL) :?>
                <img src='data:image/PNG;base64,<?php echo base64_encode($templateParams['logged_user']['image']); ?>' alt="" id="profileimageid"/>
                <?php else:?>
                <img src="assets/logo.svg" alt="" id="profileimageid"/>
                <?php endif;?>
                <p class="name-mobile">
                    <span id="name"><?php echo ($templateParams['logged_user'])['name']; ?></span>
                    <span id="tag">@<?php echo ($templateParams['logged_user'])['nickname']; ?></span>
                </p>
            </div>
            <button id="close"><span class="fa-solid fa-xmark"></span></button>
        </div>
        <div class="follows">
            <ul class="follows-list">
                <li>
                    <p class="fl-label">Follows</p>
                </li>
                <li>
                    <?php if (count($templateParams['followed']) > 0): ?>
                        <?php foreach ($templateParams['followed'] as $followed): ?>
                        <a href="./components/user_profile.php?user_id=<?php echo $followed['user_id']; ?>">
                            <img src="assets/logo.svg" alt="" />
                            <p class="fl-name">
                                <span class="fl-mainname"><?php echo $followed['name']?></span>
                                <span class="small-text">@<?php echo $followed['nickname']?></span>
                            </p>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </li>
                <li>
                    <hr class="border" />
                </li>
            </ul>
        </div>
        <div class="subscriptions">
            <ul class="sub-list">
                <li>
                    <p class="sub-label">Subscriptions</p>
                </li>
                <li>
                    <a href="#sub-pr">
                    <?php if (count($templateParams['subscriptions']) > 0): ?>
                        <?php foreach ($templateParams['subscriptions'] as $subbed): ?>
                        <a href="#fl-pr">
                            <img src="assets/logo.svg" alt="" />
                            <p class="fl-name">
                                <span class="fl-mainname"><?php echo $subbed['name']?></span>
                            </p>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
