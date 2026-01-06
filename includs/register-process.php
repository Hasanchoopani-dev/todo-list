<?php
$register_error = "" ;
if (isset($_POST["register"])){

    $username   = isset($_POST["username"])     ? db_escape(trim($_POST['username']))    : "" ;
    $password   = isset($_POST['password'])     ? db_escape($_POST['password'])    : "" ;
    $name       = isset($_POST['name'])         ? db_escape(trim($_POST['name']))        : "" ;
    $family     = isset($_POST['family'])       ? db_escape(trim($_POST['family']))      : "" ;
    $phone      = isset($_POST['phone'])        ? db_escape(trim($_POST['phone']))       : "" ;
    $birthdate  = isset($_POST['birthdate'])    ? db_escape(trim($_POST['birthdate']))   : "" ;
    $photo      = '' ;

    if(strlen($username)<=5 || strlen($password)<= 8 ){
        $register_error = "نام کاربری یا پسورد خود را درست وارد کنید";
    }else{
       $result = mysqli_query(db() , "SELECT * FROM users WHERE  username  = '$username' ");
       if($result->num_rows ){
        $register_error = "نام کاربری" . $username . "تکراری است " ;
       }else{
        //register
        $user_id       = db_insert('users' ,[
            'username'      => $username,
            'password'      => $password,
            'name'          => $name,
            'family'        => $family,
            'phone'         => $phone,
            'birthdate'     => $birthdate,
            'photo'         => $photo,
            'register_date' => date("Y-m-d H:i:s"),
        ]);
            if( $user_id ){
                redirect("login.php?register=true");
            }else{
                $register_error = "خطا در ثبت نام رخ داده است";
            }
       }
    }
}
