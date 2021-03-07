<?php 
    require "session_start.php";
    require __DIR__.'/settings.php';
    $con = con();
    if(!$con){
        die_with_error("Error connecting to database");
    }
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

<?php require APP_INCLUDE_PATH. '/header.php' ?>
<section class="container">
    <?php require APP_INCLUDE_PATH. "/form.php" ?>
</section>