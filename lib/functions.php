<?php
    if(!defined('__INCLUDED__')) die('You cannot run this file');
    
    /**
     * Show An Error Page
     * @param string error message to show
     * @return void
     */
    function die_with_error(string $errorMessage){
        require_once APP_PATH.'/500.php';
        exit;
    }

    function dieWithMsg(){
        require_once APP_PATH. '../500.php';
        exit;
    }

    /**
     * Hash password
     * @param string password string
     * @return string sha1 hashed string
     */
    function hash_pwd(string $str): string{
        return sha1(APP_KEY. $str);
    }

    /**
     * Verfiy password Hash
     * @param string $data1 input password from user
     * @param string $data2 database password stored
     * @return boolean true if they params are equal
     */
    function password_verify_hash(string $data1, string $data2){
        return hash_pwd($data1) === $data2;
    }

    /**
     * Function to echo any given string
     * @param string output to show
     * @return void
     */
    function __($s){
        echo $s;
    }

    /**
     * Compare password and confirm password
     * @param string password field
     * @param string confirm password field.
     * @return boolean true if they are equal And false otherwise
     */
    function checkPass(string $data1,string $data2){
        if($data1 === $data2) return true;
        return false;
    }

    /**
     * Collect errors from Registration form Page
     * @param string username field
     * @param string email field
     * @param string password field
     * @return array array of errors.
     */
    function collectErrors($con, string $username,string $email,string $password){
        $errorMsg = [];
        if(!$username || strlen($username) < 3 ){
            $errorMsg[] = "Invalid Username, min of 3 characters";
        }
        if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL) ){
            $errorMsg[] = "Enter a Valid Email";
        }

        if(emailExist($con, $email)){
            $errorMsg[] = "Email Already Exists";
        }

        if(!$password || strlen($password) < 8){
            $errorMsg[] = "Enter a strong password";
        }
        return $errorMsg;
    }

    /**
     * Collecting LoginForm errors
     * @param array data for form fields
     * @return array errors for form fields
     */
    function collectLoginErrors(array $data){
        $errors = [];
        
        if(!$data['email'] || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ){
            $errors[] = "Enter a Valid Email";
        }
        if(!$data['passkey'] || strlen($data['passkey']) < 8){
            $errors[] = "Password length is not valid";
        }
        return $errors;
    }

    

    /**
     * @return boolean true if a user is logged in
     */
    function isLoggedIn(){
        return (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]);
    }

    /**
     * Generate new session id on login 
     * Store the user_id in SESSION Variable
     * @return void
     */
    function login(int $id){
        session_regenerate_id(true);
        $_SESSION["isLoggedIn"] = true;
        $_SESSION["user_id"] =  $id;
    }

    /**
     * Logout user out and destroy session 
     * @return void
     */
    function logout(){
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * @param integer
     */
    function produceIntVal(int $val){
        return abs(intval($val));
    }

    /**
     * @param string comment to post to the db
     * @return string $errors to database
     */
    function checkDataErrors($data){
        $errors = "";
        if(!chk($data)){
            $errors = "Comment field can't be empty";
        }
        return $errors;
    }

    /**     
     * Check Input Data from FORM
     * @param string to be filtered
     * @return string filtered properly
    */
    function chk($data){
        $data = strip_tags($data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtolower($data);
        return $data;
    }

    /**
     * @param array data to post
     * @return boolean true if no error, false if error
     */
    function validateData($data){
        foreach($data as $eachData){
            if(!$eachData){
                return false;
            }
        }
        return true;
    }