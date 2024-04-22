<?php if(count($templateParams['posts']) == 0): ?>
<article>
    <div class="post">
        <div class="poster">
            <!-- TODO -->
            <img src="prova.png" alt="" name="profileimg" id="profileimg" />
            <p class="user-tag">
                <span class="username" name="username-post" id="username-post">No user detected</span>
                <span name="tag" id="tag">@none</span>
            </p>
        </div>
        <p>No post detected</p>
        <img src="prova.png" alt="" id="postimg" name="postimg" />
        <div class="post-interactions">
            <div class="interactions-plus-comments">
                <div class="interactions">
                    <label hidden for="upvote">Upvote post</label>
                    <i class="fa-solid fa-caret-up" name="upvote" id="upvote"></i>
                    <p>0</p>
                    <label hidden for="downvote">Downvote post</label>
                    <i class="fa-solid fa-caret-down" name="downvote" id="downvote"></i>
                </div>
                <div class="comments-icons">
                    <label hidden for="view-comments">View comments</label>
                    <i class="fa-solid fa-comments" name="view-comments" id="view-comments"></i>
                    <p>0</p>
                </div>
            </div>
            <label hidden for="save">Save post</label>
            <i class="fa-solid fa-floppy-disk" name="save" id="save"></i>
        </div>
    </div>
</div>
</article>

<?php else: foreach ($templateParams["posts"] as $articolo) {?>
<article>
    <div class="post">
        <div class="poster">
            <img src="<?php echo ASSETS.$articolo['image']; ?>" alt="" name="profileimg" id="profileimg" />
            <p class="user-tag">
                <span class="username" name="username-post" id="username-post"><?php echo $articolo['nickname']; ?></span>
                <span name="tag" id="tag">@<?php echo $dbh->getGameFromId($articolo['game_id']); ?></span>
            </p>
        </div>
        <p><?php echo $articolo['text']; ?></p>
        <?php if ($articolo['image'] != null): ?>
        <img src="prova.png" alt="" id="postimg" name="postimg" />
        <?php endif;?>
        <div class="post-interactions">
            <div class="interactions-plus-comments">
                <div class="interactions">
                    <label hidden for="upvote">Upvote post</label>
                    <i class="fa-solid fa-caret-up" name="upvote" id="upvote"></i>
                    <p><?php echo $articolo['likes']?></p>
                    <label hidden for="downvote">Downvote post</label>
                    <i class="fa-solid fa-caret-down" name="downvote" id="downvote"></i>
                </div>
                <div class="comments-icons">
                    <label hidden for="view-comments">View comments</label>
                    <i class="fa-solid fa-comments" name="view-comments" id="view-comments"></i>
                    <!-- TODO -->
                    <p>0</p>
                </div>
            </div>
            <label hidden for="save">Save post</label>
            <i class="fa-solid fa-floppy-disk" name="save" id="save"></i>
        </div>
    </div>
</div>
</article>
<?php } endif; ?>