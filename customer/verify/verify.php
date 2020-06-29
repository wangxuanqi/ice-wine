<?php
// 网站根目录
$root_dir = $_SERVER['DOCUMENT_ROOT']."/icewine";
// 连接
include("$root_dir/conn.php");


// 判断一堆参数是否全都在数组中
function contains($arr, $args) {
    $res = true;
    // 判断
    $arg_num = count($args);
    for ($i = 0; $i < $arg_num; $i++) {
        $res = $res && isset($arr[$args[$i]]);
    }
    return $res;
}

// 判断客户账号是否正确
function cid_is_right($c_id, $c_pwd) {
    // 使用全局变量$conn
    global $conn;

    // 拉黑状态也不能登录
    $sql = "select * from customer where c_id='$c_id' and c_pwd='$c_pwd' and c_state != 'blocked'";
    if (mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
        return true;
    }
    return false;
}

// 判断管理员账号是否正确
function eid_is_right($e_id, $e_pwd) {
    // 使用全局变量$conn
    global $conn;

    $sql = "select * from employee where e_id='$e_id' and e_pwd='$e_pwd'";
    if (mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
        return true;
    }
    return false;
}

// 判断客户账号是否存在
function cid_is_exist($c_id) {
    // 使用全局变量$conn
    global $conn;

    $sql = "select * from customer where c_id='$c_id'";
    if (mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
        return true;
    }
    return false;
}

// 判断员工账号是否存在
function eid_is_exist($e_id) {
    // 使用全局变量$conn
    global $conn;

    $sql = "select * from employee where e_id='$e_id'";
    if (mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
        return true;
    }
    return false;
}

// 判断是否有cookie，没有就跳回登录界面
function judge_cookie() {
    // 判断是否有c_id和c_pwd
    if (!isset($_COOKIE['c_id']) || !isset($_COOKIE['c_pwd']) 
        || !cid_is_right($_COOKIE['c_id'], $_COOKIE['c_pwd'])) {
        // 跳回登录界面
        header("Location: ../login_register/login_register.php");
    }
}






?>