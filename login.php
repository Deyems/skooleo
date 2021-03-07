<?php //require APP_INCLUDE_PATH. '/header.php' ?>
<?php
    // require "session_start.php";
    require __DIR__.'/settings.php';
    require APP_INCLUDE_PATH. '/header.php';
    // $con = con();
    // if(!$con){
    //     die_with_error("Error connecting to database");
    // }
    $emailVal = "";
    $passkeyVal = "";
    
    if(isset($_POST["login"])){
        $emailVal = $_POST['email'];
        $passkeyVal = $_POST['passkey'];
        $data = [
            'email' => $emailVal,
            'passkey' => $passkeyVal
        ];
        $errorMsg = collectLoginErrors($data);
        if(empty($errorMsg)){
            //Array or falsy value;
            $isAuthenticated = authenticate($con,$data);
            if(!$isAuthenticated){
                $errorMsg[] = "Incorrect login details";
            }
            if($isAuthenticated){
                login($isAuthenticated['id']);
                header("Location: index.php");
                exit;
            }
        }
    }
?>
    <?php //require APP_INCLUDE_PATH. '/header.php' ?>
    <section class="container">
        <div class="form-container">
            <div class="img-side"></div>
            <div class="join-form">
                <form action="" method="post">
                    <?php if(!empty($errorMsg)): ?>
                        <?php foreach($errorMsg as $message): ?>
                            <div class="show-error">
                                <?php echo $message; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div>
                        <h2>Login Here</h2>
                    </div>
                    <div class="inp-grp">
                        <input type="email" name="email" value="<?php if(!empty($errorMsg)) __($emailVal) ?>" placeholder="e.g go@gmail.com" id="email">
                    </div>
                    <div class="inp-grp">
                        <input type="password" name="passkey" value="<?php if(!empty($errorMsg)) __($passkeyVal); ?>" placeholder="Enter your password" id="passkey">
                    </div>
                   
                    <div class="sub-btn">
                        <button name="login" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </section>