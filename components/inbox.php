<ul class="inbox">
    <?php if(count($templateParams['notifs']) == 0): ?>
    <p>You've 100%'ed your notifications!</p>
    <?php else:
    foreach ($templateParams['notifs'] as $notif) { ?>
    <li>
        <div class="notification-div">
            <img src="assets/logo.svg" alt="" />
            <p class="text"><span>@<?php echo $notif['name']?></span><?php echo $notif['text']?></p>
        </div>
        <div>
            <button id="delete-notification" class="delete" aria-label="delete">
                <div class="container"><span class="fa-solid fa-trash-can"></span></div>
            </button>
        </div>
    </li>
    <?php }
    endif;?>   
</ul>