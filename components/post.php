<article class="post">
    <div class="poster">
        <?php if ($post['usrimage'] == NULL): ?>
        <img src="../assets/logo.svg" alt="" id="postimg" name="postimg" />
        <?php else: ?>
        <img src='data:image/PNG;base64,<?php echo base64_encode($post['usrimage']); ?>' alt="" name="profileimg" id="profileimg" />
        <?php endif;?>
        <p class="user-tag">
            <a href="./components/user_profile.php?user_id=<?php echo $post['user_id']; ?>">
                <span class="username" name="username-post" id="username-post"><?php echo $post['nickname']; ?></span>
            </a>
            <a id="gamelink" data-game-id=<?php echo $post['game_id']; ?> href="./components/game_profile.php?game_id=<?php echo $post['game_id']; ?>">
                <span name="tag" id="tag">@<?php echo $dbh->getGameFromId($post['game_id'])['name']; ?></span>
            </a>
        </p>
    </div>
    <p><?php echo $post['text']; ?></p>
    <?php if ($post['image'] != NULL): ?>
    <img src='data:image/PNG;base64,<?php echo base64_encode($post['image']); ?>' alt="" id="postimg" name="postimg" />
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
                <p><?php echo $post['comments'];?></p>
            </a>
        </div>
        <button id="save" class="<?php echo $dbh->isPostSaved($post['post_id']) ? 'liked' : ''?>" name="save" aria-label="save post" data-post-id=<?php echo $post['post_id']?>>
            <span class="fa-solid fa-floppy-disk"></span>
        </button>
    </div>
</article>