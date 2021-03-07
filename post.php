<?php
    require __DIR__.'/settings.php';
    require APP_INCLUDE_PATH. '/header.php';

    $post_id = (isset($_GET['post_id'])) ? abs(intval($_GET['post_id'])) : 0;

    $post = get_post($con, $post_id);
    
    $views = isset($post) ? $post['views']+1 : $post['views']+0;
    increase_views_count($con,$post_id,$views);
    
    if(!$post_id || !$post){
        header("Location: /");
        exit;
    }

    if(isset($_POST["commentbtn"])){
        $data = [
            'post_id' => $post_id,
            'user_id' => $_SESSION["user_id"],
            'comment' => $_POST["comment"]
        ];

        $errors = checkDataErrors($data['comment']);
        if(!$errors){
            $success = "";
            if(post_comment($con,$data)){
                $success = "Your comment has been added";
            }
        }
    }

    $comments = get_comments($con, $post_id);
    if($comments){
        $no_of_comments = count($comments);
    }else {
        $no_of_comments = 0;
    }
    
    if(!empty($comments)){
        $authors = get_authors($con,$comments);
    }
?>

    <section class="container section">
        <div class="post">
            <h1 class="post-title">
                <?php __($post['title']); ?>
            </h1>
            <p class="post-content"> <?php __($post['content']) ?>
            </p>
            <?php if(!empty($errors)): ?>
                <div class="show-error"><?php __($errors); ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($success)): ?>
                <div class="show-success"><?php __($success); ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="ctrl-btns">
                    <div>
                        <button class="make-comment">Make Comment</button>
                        <button class="view-comment">Show Comments</button>
                    </div>
                    <div>
                        <?php if(get_publisher_status($con,$_SESSION['user_id'],$post_id)): ?>
                            <a class="edit-btn" href="editpost.php?post_id=<?php __($post_id) ?>">Edit Post</a>
                        <?php endif; ?>
                    </div>
                </div>
                <!--Dont show until reply is clicked-->
                <div class="comment-form">
                    <form action="" method="post">
                        <div class="comment-inp-grp">
                            <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                        </div>
                        <div>
                            <button name="commentbtn" type="submit">Post</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <?php require APP_INCLUDE_PATH. '/postmeta.php'; ?>
        
        <!-- Dont show until comments is clicked-->
        <div class="comments-wrapper">
            <?php if($comments): ?>
            <?php for ($i=0; $i < count($comments) ; $i++): ?>
                <div class="comments-made">
                    <div class="auth-time-wrapper">
                        <div>
                            <!-- Only Render When It is that user -->
                            <div class="edit">
                                <?php if(intval($_SESSION['user_id']) === intval($comments[$i]['user_id']) ): ?>
                                <a href="editcomment.php?post_id=<?php __($post_id) ?>&comment_id=<?php __($comments[$i]['id']) ?>" class="edit-btn">edit</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="commenter">
                                <?php __($authors[$i]) ?>
                            </div>
                            <div class="comment-time"><?php __($comments[$i]['comment_at']) ?></div>
                        </div>
                    </div>
                    <div class="comment-post">
                        <?php __($comments[$i]['comment']); ?>
                    </div>
                </div>
            <?php endfor; ?>
            <?php else: ?>
                <div>No comments made yet</div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>