<?php
    require __DIR__."/session_start.php";
    require __DIR__.'/settings.php';
    $con = con();
    if(!$con){
        die_with_error("Error connecting to database");
    }
    $posts = get_posts($con);
?>

    <?php require APP_INCLUDE_PATH. '/header.php' ?>
    <section class="container section">
        <?php foreach($posts as $post): ?>
            <?php $comments = get_comments($con, $post['id']);
                if($comments){
                    $no_of_comments = count($comments);
                }else {
                    $no_of_comments = 0;
                } 
            ?>
        <div class="post">
            <h1 class="post-title">
                <?php if(isLoggedIn()): ?>
                    <a href="post.php?post_id=<?php __($post['id']); ?>">
                        <?php __($post['title']); ?>
                    </a>
                <?php else: ?>
                    <a href="/"><?php __($post['title']); ?> </a>
                <?php endif; ?>
            </h1>                
            <p class="post-content"> <?php __($post['content']); ?>
            </p>
        </div>
        <?php $post_id = isset($post['id']) ? $post['id'] : 0; ?>
        <?php require APP_INCLUDE_PATH. '/postmeta.php'; ?>
        <?php endforeach; ?>
    </section>
</body>
</html>