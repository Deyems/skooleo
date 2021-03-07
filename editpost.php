<?php 
    require __DIR__.'/settings.php';
    require APP_INCLUDE_PATH. '/header.php';

    $title = "";
    $content = "";

    $post_id = (isset($_GET['post_id'])) ? abs(intval($_GET['post_id'])) : 0;
    $post = get_post($con, $post_id);
    
    $title = $post["title"];
    $content = $post["content"];

    if(isset($_POST["edit_post"])){
        $title = chk($_POST["title"]);
        $content = chk($_POST["content"]);
        $data = [
            'title' => $title,
            'content' => $content,
            'user_id' => $_SESSION["user_id"]
        ];

        if(!validateData($data)){
            $error = "Your fields cannot be empty";
        }else{
            if(update_post($con,$data,$post_id)){
                $success = "Post updated successfully";
            }else{
                $error = "There was an error while updating post";
            }
        }
    }
    
?>

<section class="container">
    <?php require APP_INCLUDE_PATH. "/form.php" ?>
</section>