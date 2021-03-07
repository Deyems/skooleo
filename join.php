<?php
    require __DIR__.'/settings.php';
    $con = con();
    if(!$con){
        die_with_error("Error connecting to database");
    }
    $usernameVal = "";
    $emailVal = "";
    $passkeyVal = "";
    $passkeyVal2 = "";

    if(isset($_POST["join"])){

        if(checkPass($_POST['passkey'],$_POST['passkey2'])){
            $usernameVal = $_POST['username'];
            $emailVal = $_POST['email'];
            $passkeyVal = $_POST['passkey'];
            $passkeyVal2 = $_POST['passkey2'];

            $data = [
                'username' => $usernameVal,
                'email' => $emailVal ,
                'passkey' => $passkeyVal
            ];

            $errorMsg = collectErrors($con, $data['username'],$data['email'],$data['passkey']);

            if(empty($errorMsg)){
                if(register($con,$data)){
                    $successMsg = "You have successfully registered<br />Login to view Posts";
                    // header("Location index.php");
                }
            }
        }else{
            $errorMsg[] = "Passwords must be same";
        }
    }
?>
    <?php require APP_INCLUDE_PATH. '/header.php' ?>
    <section class="container">
        <div class="form-container">
            <div class="img-side"></div>
            <div class="join-form">
                <form action="" class="form-to-join" method="post">
                    
                    <?php if(!empty($successMsg)): ?>
                        <div class="show-success">
                            <?php echo $successMsg; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($errorMsg)): ?>
                        <?php foreach($errorMsg as $message): ?>
                            <div class="show-error">
                                <?php echo $message; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div>
                        <h2>Join Us</h2>
                    </div>
                    <div class="inp-grp">
                        <input type="text" value="<?php if(!empty($errorMsg)) __($usernameVal) ?>" name="username" placeholder="choose a username" id="username">
                    </div>
                    <div class="inp-grp">
                        <input type="email" value="<?php if(!empty($errorMsg))__($emailVal) ?>" name="email" placeholder="e.g go@gmail.com" id="email">
                    </div>
                    <div class="inp-grp">
                        <input type="password" value="<?php if(!empty($errorMsg)) __($passkeyVal) ?>" name="passkey" placeholder="Enter your password" id="passkey">
                    </div>
                    <div class="inp-grp">
                        <input type="password" value="<?php if(!empty($errorMsg)) __($passkeyVal2) ?>" name="passkey2" placeholder="Confirm your password" id="passkey2">
                    </div>
                    <div class="sub-btn">
                        <button class="join" name="join" type="submit">Join</button>
                    </div>
                </form>
            </div>
        </div>
    </section>