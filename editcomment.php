<?php
    require "session_start.php";
    require __DIR__.'/settings.php';
    $con = con();
    if(!$con){
        die_with_error("Error connecting to database");
    }

    $comment_id = (isset($_GET['comment_id'])) ? abs(intval($_GET['comment_id'])) : 0;
    $post_id = (isset($_GET['post_id'])) ? abs(intval($_GET['post_id'])) : 0;
    
    if(!$comment_id || !$post_id){
        header("Location: /");
        exit;
    }

    $content = get_comment($con, $comment_id,$post_id)['comment'];
    if(!$content){
        header("Location: /");
        exit;
    }

    if(isset($_POST["edit_comment"])){
        $comment = chk($_POST["content"]);
        $data = [
            'comment' => $comment,
            'comment_id' => $comment_id
        ];
        
        if(!validateData($data)){
            $error = "Your fields cannot be empty";
        }else{
            if(update_commment($con,$data)){
                $success = "Comment updated successfully";
            }else{
                $error = "There was an error while updating comment";
            }
        }
    }
?>

<?php require APP_INCLUDE_PATH. '/header.php' ?>
<section class="container">
    <?php require APP_INCLUDE_PATH. "/form.php" ?>
</section>