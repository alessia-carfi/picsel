<?php if(count($templateParams['posts']) == 0): ?>
    <p>No post detected</p>

<?php else:
        foreach ($templateParams["posts"] as $post) {
            include __DIR__ . '/components/post.php';
        } 
    endif;
?>
</div>