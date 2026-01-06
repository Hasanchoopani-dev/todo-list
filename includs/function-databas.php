<?php
function db(){
    global $db;
    return $db;
};

function db_affected_rows(){
    return mysqli_affected_rows(db());
}



function db_log($error){
    file_put_contents(
        "db-error.txt",
        date("Y-m-d H:i:s"). "=>" . $error . PHP_EOL,
        FILE_APPEND,
    );
}
function db_escape($string){
    return mysqli_real_escape_string(db(),$string);
}

function db_insert($table,$data){
    $cols  = array_keys($data);
    $cols_sql =implode(', ',$cols);
    $vals = array_values($data);
    $new_data = [];
    foreach($vals as $val ){
        if($val === NULL){
            $new_data[]='NULL';
        }else{
            $new_data[]="'$val'";
        }
    }
    $vals_sql =implode(', ' ,$new_data);
    $sql = "INSERT INTO $table ($cols_sql) VALUES ($vals_sql)";
    $result=@mysqli_query(db(),$sql);
    if(!$result){
        db_log(mysqli_error(db()));
        return false;
    }
    return mysqli_insert_id(db());
}

function db_query($sql){
    $result = @mysqli_query(db(),$sql);
    if($result){
        return $result;
    }

    db_log(mysqli_error(db()));

    return false;
}













