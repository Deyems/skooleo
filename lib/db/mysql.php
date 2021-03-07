<?php
if(!defined('__INCLUDED__')) die('You cannot run this file');

/**
 * Connect to mysql
 * @return resource|boolean
 */

function con(){
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    if(!$con){
        return false;
    }
    return $con;
}

/**
 * Get Posts from database
 * @param object connection object
 * @return array array retrieved from database
 */

function get_posts($con): array{
    $sql = 'SELECT * FROM posts';
    $output = [];
    if($result = mysqli_query($con,$sql)){
        while($row = mysqli_fetch_assoc($result)){
            $output[] = $row;
        }
    }else {
        //Log out error;
    }
    return $output;
}

/**
 * Insert Posts
 * @param object connection to database
 * @param array data to insert to database
 * @return boolean true for good queries false for bad queries.
 */
function create_post($con, array $data){
    if(!isset($data['created_at'])){
        $data['created_at'] = date('Y-m-d H:i:s');
    }
    if(!isset($data['visits'])){
        $data['visits'] = 0;
    }
    
    $sql = 'INSERT INTO posts(title, content, user_id, visits, created_at)
    VALUES (?,?,?,?,?)';

    $stmt = mysqli_prepare($con, $sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt, 'ssdis', $data['title'], $data['content'],$data['user_id'], $data['visits'], $data['created_at']);
        
        if(mysqli_stmt_execute($stmt)){
            return true;
        }
    }
    return false;
}


/**
 * To retrieve a single POST
 * @param object $con connection to db
 * @param integer $post_id to access post
 * @return array|boolean array if there is result OR false if there is no result
 */
function get_post($con,int $post_id){

    $sql = 'SELECT title, content, user_id, visits, created_at FROM posts
    WHERE id=?';
    $stmt = mysqli_prepare($con,$sql);
    if(!$stmt) return false;
    if($stmt){
        $res = mysqli_stmt_bind_param($stmt,'d',$post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $title,$content,$user_id, $visits, $created_at);
        while(mysqli_stmt_fetch($stmt)){
            $output = 
            [
                'title' => $title,
                'content' => $content,
                'user_id' => $user_id,
                'views' => $visits,
                'created_at' => $created_at
            ];
        }
        mysqli_stmt_close($stmt);
        return $output;
    }
}

/**
 * Update a Post By the Author
 * @param object connection to database
 * @param array data from form fields
 * @param integer post_id to identify post on db
 * @return boolean true if update is successful false if Unsuccessful
 */
function update_post($con,array $data,int $post_id){
    $sql = 'UPDATE posts SET title=?, content=? WHERE id=?';
    $stmt = mysqli_prepare($con,$sql);
    
    if($stmt){
        mysqli_stmt_bind_param($stmt,"ssi",$data['title'],$data['content'],$post_id);
        if(mysqli_stmt_execute($stmt)){
            return true;
        }else return false;
    }
    return false;
}

/**
 * Counting Posts on the Db
 * @param object connection to db
 * @return integer total rows on the database Or Zero if no rows
 */
function count_post($con):int{
    $sql = 'SELECT COUNT(*) as c FROM posts';
    if($result = mysqli_query($con,$sql)){
        $row = mysqli_fetch_assoc($result);
        return intval($row['c']);
    }
    return 0;
}

/**
 * Register a user
 * @param object connection to database
 * @param array data to send to db
 * @return boolean true if registration is successful false if Unsuccessful
 */
function register($con, array $data){
    $sql = 'INSERT INTO users(name,password,email)
    VALUES(?,?,?)';

    $stmt = mysqli_prepare($con, $sql);
    $password = hash_pwd($data['passkey']);
    mysqli_stmt_bind_param($stmt,"sss",
    $data['username'], $password, $data['email']);
   
    $isexecuted = mysqli_stmt_execute($stmt);

    if($isexecuted) return true;
    
    return false;
}


/**
 * Check For Existing User emails
 * @param string email for form field
 * @return boolean true if email exists false if email doesn't exist
 */
function emailExist($con, $user){
    
    $sql = 'SELECT email FROM users WHERE email=?';
    $stmt = mysqli_prepare($con,$sql);
    $output = [];
    if($stmt){
        mysqli_stmt_bind_param($stmt,"s", $user);
        mysqli_stmt_execute($stmt);
           
      mysqli_stmt_bind_result($stmt,$email);
      while (mysqli_stmt_fetch($stmt)) {
        $output[] = $email;
        }
        if(!empty($output)) {
            return true;
        };
        return false;
        mysqli_stmt_close($stmt);
    }
}

/**
 * Login A User
 * @param object $connection to database
 * @param array user details from login form
 * @return boolean|object object if details are correct and false if details are not.
 */
function authenticate($con,$data){
    $sql = 'SELECT id,email, password FROM users WHERE email=?';
    $stmt = mysqli_prepare($con,$sql);    
    $output = [];
    if($stmt){
        mysqli_stmt_bind_param($stmt,"s", $data['email']);
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_bind_result($stmt, $id, $email,$password);
            while(mysqli_stmt_fetch($stmt)){
                $output = [
                    'email' => $email,
                    'passkey'=> $password,
                    'id' => $id
                ];
            }
            if(empty($output)){
                return false;
            }
            if($output['email'] === $data['email']){
                
                if(password_verify_hash($data['passkey'],$output['passkey'])){
                    return $output;
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

/**
 * Function to Post Comment
 * @param object connection to database
 * @param array $data to send to database
 * @return boolean true if successful and false otherwise
 */
function post_comment($con, array $data){
    $sql = "INSERT INTO comments(post_id,user_id,comment)
    VALUES(?,?,?)";
    $stmt = mysqli_prepare($con,$sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"iis",
        $data['post_id'],
        $data['user_id'],
        $data['comment']);
        if(mysqli_stmt_execute($stmt)){
            return true;
        }
    }
    return false;
}
/**
 * Get All Comments Attached to a post
 * @param object connection to database
 * @param integer post_id
 * @return boolean|array false if comments !exists OR array if comments exist
 */
function get_comments($con, int $post_id){
    // $sql = "SELECT * FROM comments WHERE post_id=$post_id";
    // $query = mysqli_query($con,$sql);
    // if($query){
    //     while($row = mysqli_fetch_assoc($query)){
    //         $result[] = $row;
    //     }
    //     return $result;
    // }
    // return false;

    $sql = "SELECT * FROM comments WHERE post_id=?";
    $stmt = mysqli_prepare($con,$sql);
    $output = [];
    if(!$stmt) return false;
    if($stmt){
        mysqli_stmt_bind_param($stmt,'i', $post_id);
        if(!mysqli_stmt_execute($stmt)) return false;
        mysqli_stmt_bind_result($stmt, $id,$post_id, $comment, $user_id,$comment_at);
        while(mysqli_stmt_fetch($stmt)){
            $output[] =  
            [
                'id' => $id,
                'post_id' => $post_id,
                'comment' => $comment,
                'user_id' => $user_id,
                'comment_at' => $comment_at
            ];
        }
        mysqli_stmt_close($stmt);
        return $output;
    }

    $sql = 'SELECT comment, user_id, post_id FROM comments
    WHERE id=? AND post_id=?';
    $stmt = mysqli_prepare($con,$sql);
    if(!$stmt) return false;
    if($stmt){
        mysqli_stmt_bind_param($stmt,'ii',$comment_id,$post_id);
        if(!mysqli_stmt_execute($stmt)) return false;
        mysqli_stmt_bind_result($stmt, $comment,$user_id,$post_id);
        while(mysqli_stmt_fetch($stmt)){
            $output = 
            [
                'comment' => $comment,
            ];
        }
        mysqli_stmt_close($stmt);
        return $output;
    }
}

/**
 * GET Single Comment for Update
 * @param object connection to database
 * @param integer $post_id
 * @param integer commentid
 */
function get_comment($con, int $comment_id, int $post_id){
    $sql = 'SELECT comment, user_id, post_id FROM comments
    WHERE id=? AND post_id=?';
    $stmt = mysqli_prepare($con,$sql);
    if(!$stmt) return false;
    if($stmt){
        mysqli_stmt_bind_param($stmt,'ii',$comment_id,$post_id);
        if(!mysqli_stmt_execute($stmt)) return false;
        mysqli_stmt_bind_result($stmt, $comment,$user_id,$post_id);
        while(mysqli_stmt_fetch($stmt)){
            $output = 
            [
                'comment' => $comment,
            ];
        }
        mysqli_stmt_close($stmt);
        return $output;
    }
}

/**
 * Updating comment on the db
 * @param object connection to db
 * @param integer comment id
 */
function update_commment($con, array $data){
    $sql = 'UPDATE comments SET comment=? WHERE id=?';
    $stmt = mysqli_prepare($con,$sql);
    
    if($stmt){
        mysqli_stmt_bind_param($stmt,"si",$data['comment'], $data['comment_id']);
        if(mysqli_stmt_execute($stmt)){
            return true;
        }else return false;
    }
    return false;
}

/**
 * GET Author for comments
 * @param object connection to db
 * @param array comments from comments table
 * @return array authors array
 */
function get_authors($con,array $comments){
    //This can be better if OOP is involved;
    //By converting array to Object PDO_FETCH_CLASS
    
    foreach($comments as $comment){
        $user_id = $comment['user_id'];
        $sql = "SELECT name FROM users WHERE id=$user_id";
        $query = mysqli_query($con,$sql);
        if($query){
            $row = mysqli_fetch_assoc($query);
            $authors[] = $row['name'];
        }
    }
    return $authors;
}

/**
 * Get Author of A Post
 * @param object connection to db
 * @param int userid to find the author of post
 * @return array|boolean array for found author otherwise false
 */
function get_publisher($con,int $user_id){
    $sql = "SELECT name FROM users WHERE id=$user_id";
    $query = mysqli_query($con,$sql);
    if($query){
        $result = mysqli_fetch_assoc($query);
        return $result;
    }
    return false;
}

/**
 * Control How Access to who can Edit Post
 * @param object connection to db
 * @param int userid to find the author of post
 * @return boolean true if it is the author otherwise false
 */
function get_publisher_status($con,int $user_id,int $post_id){
    $sql = "SELECT * FROM posts WHERE id=$post_id";
    $query = mysqli_query($con,$sql);
    if($query){
        $result = mysqli_fetch_assoc($query);
        if(intval($result['user_id']) === $user_id){
            return true;
        }else return false;
    }
    return false;
}

/**
 * To Count Views
 * @param object connection to database
 * @param integer post id
 * @param integer no of views 
 */
function increase_views_count($con, $post_id, $views){
    $sql = 'UPDATE posts SET visits=? WHERE id=?';
    $stmt = mysqli_prepare($con,$sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"ii",$views,$post_id);
        mysqli_stmt_execute($stmt);
    }
}

/**
 * Get Views Count
 * @param object connection object
 * @param integer post id
 * @return integer no of views
 */
function get_no_of_views($con, $post_id){
    $sql = 'SELECT visits FROM posts WHERE id=?';

    $stmt = mysqli_prepare($con,$sql);
    $output = 0;
    mysqli_stmt_bind_param($stmt,'d',$post_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $visits);
    while(mysqli_stmt_fetch($stmt)){
        $output = $visits;
    }
    mysqli_stmt_close($stmt);
    return $output;   
}

/**
 * COUNT UNIQUE VISITORS
 * @param object connection object
 * @param string user ip address
 * @return string user ip address.
 */
function check_unique_visitors($con, $user_ip){
    // $user_ip = $_SERVER['REMOTE_ADDR'];
    $output = "";

    $sql = 'SELECT ip_address FROM unique_visitors
    WHERE ip_address=?';
    $stmt = mysqli_prepare($con,$sql);
   
    if($stmt){
        mysqli_stmt_bind_param($stmt,'s',$user_ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ip_address);
        while(mysqli_stmt_fetch($stmt)){
            $output = $ip_address;
        }
        if(!$output){
            save_unique_visitors($con, $user_ip);
        }
        mysqli_stmt_close($stmt);
        return $output;
    }
}

/**
 * SAVE UNIQUE VISITORS
 * @param object connection object
 * @param string user ip address
 */
function save_unique_visitors($con,$user_ip){
    $sql = "INSERT INTO unique_visitors(ip_address) VALUES(?)";
    $stmt = mysqli_prepare($con,$sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"s",$user_ip);
        mysqli_stmt_execute($stmt);
    }
}


/**
 * FIND TOTAL VISITORS
 * @param object connection object
 * @return integer zero if no visitors else returns total count of visitors
 */
function total_unique_visitors($con){
    $sql = 'SELECT COUNT(*) as visitors FROM unique_visitors';
    if($result = mysqli_query($con,$sql)){
        $row = mysqli_fetch_assoc($result);
        return intval($row['visitors']);
    }
    return 0;
}