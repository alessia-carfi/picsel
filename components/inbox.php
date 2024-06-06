<ul class="inbox">
    <?php if(count($templateParams['notifs']) == 0): ?>
    <p>You've 100%'ed your notifications!</p>
    <?php else:
    foreach ($templateParams['notifs'] as $notif) { ?>
    <li>
        <div class="notification-div">
            <p class="text"><span>@<?php echo $notif['name']?></span><?php echo $notif['text']?></p>
            <button id="delete-notification-<?php echo $notif['notification_id']?>" name="delete-notification" data-id="<?php echo $notif['notification_id'];?>" class="delete" aria-label="delete">
                <div class="container"><span class="fa-solid fa-trash-can"></span></div>
            </button>
        </div>
    </li>
    <?php }
    endif;?>   
</ul>