<div class="shadow" id="shadowid">
    <div class="sidemenu" id="sidemenuid">
        <div class="top-sidemenu"  id="top-sidemenu" style="display: none">
            <a title="Your profile" class=profile-mobile href="./components/user_profile.php?user_id=<?php echo $templateParams['logged_user']['user_id']; ?>">
                <?php if ($templateParams['logged_user']['image'] != NULL) :?>
                <img alt="" src='data:image/PNG;base64,<?php echo base64_encode($templateParams['logged_user']['image']); ?>' id="profileimageid"/>
                <?php else:?>
                <img src="assets/logo.svg" alt="" id="profileimageid"/>
                <?php endif;?>
                <div class="name-mobile">
                    <span id="name"><?php echo ($templateParams['logged_user'])['name']; ?></span>
                    <span id="tag">@<?php echo ($templateParams['logged_user'])['nickname']; ?></span>
                </div>
            </a>
            <button id="close"><span class="fa-solid fa-xmark"></span></button>
        </div>
        <ul class="follows-list">
            <li>
                <p class="fl-label">Follows</p>
            </li>
            <?php if (count($templateParams['followed']) > 0): ?>
                <?php foreach ($templateParams['followed'] as $followed): ?>
                <li>
                    <a title="<?php echo $followed['name']; ?>" href="./components/user_profile.php?user_id=<?php echo $followed['user_id']; ?>">
                        <?php if ($followed['image'] != NULL):?>
                        <img alt="" src='data:image/PNG;base64,<?php echo base64_encode($followed['image']); ?>' />
                        <?php else: ?>
                        <img alt="" src="assets/logo.svg" />
                        <?php endif;?>
                        <p class="fl-name">
                            <span class="fl-mainname"><?php echo $followed['name']?></span>
                            <span class="small-text">@<?php echo $followed['nickname']?></span>
                        </p>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <hr cls="border" />
        <ul class="sub-list">
            <li>
                <p class="sub-label">Subscriptions</p>
            </li>
            <?php if (count($templateParams['subscriptions']) > 0): ?>
                <?php foreach ($templateParams['subscriptions'] as $subbed): ?>
                <li>
                    <a title="<?php echo $subbed['name']; ?>" href="./components/game_profile.php?game_id=<?php echo $subbed['game_id']; ?>">
                        <?php if ($subbed['image'] != NULL):?>
                        <img alt="" src='data:image/PNG;base64,<?php echo base64_encode($subbed['image']); ?>' />
                        <?php else: ?>
                        <img alt="" src="assets/logo.svg" />
                        <?php endif; ?>
                        <p class="fl-name">
                            <span class="fl-mainname"><?php echo $subbed['name']?></span>
                        </p>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
