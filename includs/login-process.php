<?php
$error="";
if(isset($_POST["login"])){
    $username   = $_POST["username"];
    $password   = $_POST["password"];
    if(strlen($username ) < 3 || strlen( $password ) < 5 ) {
        $error  = "نام کاربری یا گذرواژه را درست وارد کنید";
    }else{
    $user       = user_login($username , $password );
    if($user){
        //login
        $_SESSION["user"] = $user['ID'  ];
        redirect("index.php" );
    }else{
        $error = "نام کاربری یا گذرواژه اشتباه است";
    }
    }

}
