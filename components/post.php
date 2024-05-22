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
                <button id="upvote" class="<?php echo $dbh->getPostVoteType($post['post_id']) == "Up" ? 'liked' : ''?>" name="upvote" data-post-id=<?php echo $post['post_id']?> aria-label="upvote post">
                    <span class="fa-solid fa-caret-up"></span>
                </button>
                <p><?php echo $post['likes']?></p>
                <button id="downvote" class="<?php echo $dbh->getPostVoteType($post['post_id']) == "Down" ? 'liked' : ''?>" name="downvote" data-post-id=<?php echo $post['post_id']?> aria-label="downvote post">
                    <span class="fa-solid fa-caret-down"></span>
                </button>
            </div>

            <a href="openpost.php?post_id=<?php echo $post['post_id']; ?>" class="comments-icons">
                <button id="view-comments" aria-label="view comments">
                    <span class="fa-solid fa-comments"></span>
                </button>
                <!-- TODO -->
                <p>0</p>
            </a>
        </div>
        <button id="save" name="save" aria-label="save post" data-post-id=<?php echo $post['post_id']?>>
            <span class="fa-solid fa-floppy-disk"></span>
        </button>
    </div>
</div>