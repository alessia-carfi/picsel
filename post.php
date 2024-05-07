<div class="post">
    <div class="poster">
        <img src="<?php echo $post['image']; ?>" alt="" name="profileimg" id="profileimg" />
        <p class="user-tag">
            <span class="username" name="username-post" id="username-post"><?php echo $post['nickname']; ?></span>
            <span name="tag" id="tag">@<?php echo $dbh->getGameFromId($post['game_id']); ?></span>
        </p>
    </div>
    <p><?php echo $post['text']; ?></p>
    <?php if ($post['image'] != null): ?>
    <img src="prova.png" alt="" id="postimg" name="postimg" />
    <?php endif;?>
    <div class="post-interactions">
        <div class="interactions-plus-comments">
            <div class="interactions">
                <label hidden for="upvote">Upvote post</label>
                <i class="fa-solid fa-caret-up" name="upvote" id="upvote"></i>
                <p><?php echo $post['likes']?></p>
                <label hidden for="downvote">Downvote post</label>
                <i class="fa-solid fa-caret-down" name="downvote" id="downvote"></i>
            </div>
            
            <a href="openpost.php?post_id=<?php echo $post['post_id']; ?>" class="comments-icons">
                <label hidden for="view-comments">View comments</label>
                <i class="fa-solid fa-comments" name="view-comments" id="view-comments"></i>
                <!-- TODO -->
                <p>0</p>
            </a>
        </div>
        <label hidden for="save">Save post</label>
        <i class="fa-solid fa-floppy-disk" name="save" id="save"></i>
    </div>
</div>