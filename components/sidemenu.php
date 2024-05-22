<div class="shadow" id="shadowid">
    <div class="sidemenu" id="sidemenuid">
        <div class="top-sidemenu"  id="top-sidemenu" style="display: none">
            <div class=profile-mobile>
                <img src="assets/logo.svg" alt=""/>
                <p class="name-mobile">
                    <span id="name">Franchino</span>
                    <span id="tag">@franchino</span>
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
                        <a href="#fl-pr">
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
                    <p class="border"></p>
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
