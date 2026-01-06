<?php
function user_login($username , $password ){
    $username = db_escape($username);
    $password = db_escape($password);
    $login_sql = "SELECT * FROM users WHERE username = '$username' AND  password ='$password';";
    $result = @mysqli_query(db(), $login_sql);
    if ($result){
        if($result -> num_rows){
            return mysqli_fetch_assoc($result);
        }
    }else{
        db_log(mysqli_error(db()));
    }
    return false;
}
function user_logout(){
    if(is_login()){
        unset($_SESSION["user"]);
    }
    return true;
}
function is_login(){
    return isset($_SESSION['user']);
}
function get_user($user_id){
    $user_id    = intval($user_id);
    $sql        = " SELECT * FROM users WHERE ID = $user_id";
    $result = @mysqli_query(db(),$sql);
    if($result){
        if($result -> num_rows){
            return mysqli_fetch_assoc($result);
        }
    }
    return false;
}
function get_current_user(){
    $user_id = $_SESSION['user'];
    return get_user($user_id );
}
