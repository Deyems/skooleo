<?php $comment_id = isset($_GET['comment_id']) ? $_GET['comment_id'] : ''; ?>
<?php $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : ''; ?>
<section class="form-container-post">
    <form action="" method="post">
        <?php if(!empty($success)): ?>
            <div class="show-success"> <?php __($success); ?> </div>
        <?php endif; ?>
        
        <?php if(!empty($error)): ?>
            <div class="show-error"><?php __($error); ?> </div>
        <?php endif; ?>
        
        <div class="inp-grp">
            <?php if(!$comment_id): ?>
            <div>
                <label for="title">Title</label>
            </div>
            <div>
                <input type="text" name="title" value="<?php if(!empty($error) || !empty($title)) __($title); ?>" placeholder="What title will you give your post?" id="title">
            </div>
            <?php endif; ?>
        </div>
        <div class="inp-grp">
            <div>
                <label for="content">Content</label>
            </div>
            <div>
                <textarea name="content" id="content" cols="30" placeholder="What is the content of your post?" rows="10">
                    <?php if(!empty($error) || !empty($content)) __($content); ?>
                </textarea>
            </div>
        </div>
        <div class="sub-grp">
            <?php if($comment_id && $post_id): ?>
                <button name="edit_comment" type="submit">Update Comment</button>
            <?php elseif($post_id): ?>
                <button name="edit_post" type="submit">Update Post</button>
            <?php else: ?>
                <button name="create_post" type="submit">Create Post</button>
            <?php endif; ?>
        </div>
    </form>
</section>