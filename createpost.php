<?php 
    require __DIR__.'/settings.php';
    require APP_INCLUDE_PATH. '/header.php';
    $title = "";
    $content = "";

    if(isset($_POST["create_post"])){
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
            if(create_post($con,$data)){
                
                $success = "Post created successfully";
            }else{
                $error = "There was an error while creating post";
            }
        }
    }
    
?>

<section class="container">
    <?php require APP_INCLUDE_PATH. "/form.php" ?>
</section>