<?php
function insert_task($title,$status, $progress,$date){
    //Add new task to user tasks
    $created_at=date("Y-m-d H:i:s");
    $task  = [
    'user_id'       => get_current_user_id(),
    'title'         => db_escape($title),
    'content'       => '',
    'status'        => db_escape($status),
    'precent'       => abs(intval($progress)),
    'due_date'      => db_escape($date),
    'createde_at'   => $created_at,
    'updated_at'    => $created_at,
    ];
    return db_insert('tasks', $task);
}
function delete_task($task_id){
  $task_id = abs(intval($task_id));
  $current_user_where ='AND user_id =' . get_current_user_id();
  $delete_sql = "DELETE FROM tasks WHERE ID = $task_id $current_user_where";
  return db_query($delete_sql);
  if($result ){
    return db_affected_rows();
  }
  return false;
}


function get_task($task_id){
    $task_id = abs(intval($task_id));
    $current_user_where ='AND user_id =' . get_current_user_id();
    $sql     ="SELECT * FROM tasks WHERE ID = $task_id $current_user_where";
    $result  =db_query($sql);
    if($result && $result->num_rows){
        return mysqli_fetch_assoc($result);
    }
    return false;
}


function edit_task($task_id,$title,$status, $progress,$date){
    $task_id    = abs(intval($task_id));
    $progress = abs(intval($progress));
    $title      = db_escape($title);
    $status     = db_escape($status);
    $date       = db_escape($date);

    return db_update(
        'tasks',
        [
                        'title'=> $title,
                        'status'=> $status,
                        'precent'=> $progress,
                        'due_date'=>$date,
                     ],
         [
                        'ID'=>(int)$task_id,
                        'user_id'=> get_current_user_id(),
                     ]

    );
}




function get_user_tasks($limit =false){

    //get user tasks
    $user_id    =  (int)get_current_user_id();
    $sql        = "SELECT * FROM tasks WHERE user_id = $user_id";
    if($limit!==false){
        $limit = (int) $limit;
        $sql .= " LIMIT $limit" ;
    }
    $result = db_query($sql);
    if( $result && $result->num_rows ) {

        return mysqli_fetch_all($result , MYSQLI_ASSOC);
    }
    return [];

}







function get_task_label($status){
    $statuses = [
        'queue'     => 'در صف',
        'doing'     => 'در حال انجام',
        'done'      => "انجام شده",
        'expire'    => "منقضی شده",
    ];
    return $statuses[$status];
}
function get_remain_days($date){
    $target = strtotime($date);
    $rimain = $target - time();
    $days   = round($rimain / 86400);
    if($days > 0 && $days < 5 ){
        return $days . "باقی مانده";
    }
    return "";
}


function get_task_stats(){
        $stats = [
        "queue"     => 0,
        "doing"     => 0,
        "done"      => 0,
        "expire"    => 0,
    ];

    $user_id    = get_current_user_id();
    $sql        = "SELECT status ,COUNT(*) as total FROM `tasks` WHERE user_id = $user_id GROUP BY status ";
    $result     = db_query($sql);
    if(!$result || !$result->num_rows){
        return $stats;
    }
    $tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);


    foreach($tasks as $task){
         $status  = $task['status'];
         $stats[$status]= $task['total'];

    }
    return $stats;
}
