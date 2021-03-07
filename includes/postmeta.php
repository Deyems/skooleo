<div class="post-meta">
    <div>Published on <?php __($post['created_at']) ?> by 
        <?php if($post_id): ?>
            <?php __(get_publisher($con,intval($post['user_id']))['name']); ?>
        <?php else: ?>
        <?php __(get_publisher($con,intval($post['user_id']))['name']); ?>
        <?php endif; ?>
    </div>
    <div class="post-meta-ratings">
            <div><?php __(get_no_of_views($con, $post_id)); ?> views</div>
        <?php if($no_of_comments > 1): ?>
            <div><?php __($no_of_comments) ?> comments</div>
        <?php elseif($no_of_comments == 1): ?>
            <div><?php __($no_of_comments) ?> comment</div>
        <?php else: ?>
            <div>No comments yet</div>
        <?php endif; ?>
    </div>
</div>