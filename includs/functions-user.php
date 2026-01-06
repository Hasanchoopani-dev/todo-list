<?php
function user_login($username , $password ){
    $username = db_escape($username);
    $password = db_escape($password);
    $login_sql = "SELECT * FROM users WHERE username = '$username' AND  password ='$password';";
    $result = db_query($login_sql);
    if ($result){
        if($result -> num_rows){
            return mysqli_fetch_assoc($result);
        }
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
function get_current_user_id(){
    return $_SESSION['user'];
}
function get_user($user_id){
    $user_id    = intval($user_id);
    $sql        = " SELECT * FROM users WHERE ID = $user_id";
    $result = db_query($sql);
    if($result){
        if($result -> num_rows){
            return mysqli_fetch_assoc($result);
        }
    }
    return false;
}
    function current_user(){
        $user_id = $_SESSION['user'];
        return get_user($user_id );
    }
