<?php if(count($templateParams['posts']) == 0): ?>
    <p>No post detected</p>

<?php else: foreach ($templateParams["posts"] as $post) {?>
    <?php include 'post.php'; ?>
    <?php } endif; ?>
</div>