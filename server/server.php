<?php
// 网站根目录
$root_dir = $_SERVER['DOCUMENT_ROOT']."/icewine";
// 连接到数据库（两个全局变量$conn和$db）
include("$root_dir/conn.php");
// 加载验证模块
include("$root_dir/customer/verify/verify.php");
// 开启会话，用于传数据
session_start();




/*------------提供服务的函数------------*/
// 注册
function register() {
    // 没有这两个值，直接结束
    if (!contains($_POST, Array('id', 'pwd'))) {
        return;
    }
    
    // 正常情况
    // 获取账号密码，随机产生名字
    $id = $_POST['id'];
    $pwd = $_POST['pwd'];
    // 使用全局变量$conn
    global $conn;

    // c类账号并且不存在
    if ($id[0] == 'c' && !cid_is_exist($id)) {
        $name = '顾客'.$id;
        // 插入
        $sql = "insert into customer(c_id, c_pwd, c_name) VALUES('$id', '$pwd', '$name')";
        mysqli_query($conn, $sql);
        echo $sql;
        // 注册成功
        $_SESSION["register_res"] = 'true';
        header("Location: ../login_register/login_register.php");
    }
    // e类账号并且不存在
    else if ($_POST['id'][0] == 'e' && !eid_is_exist($id)) {
        $name = '员工'.$id;
        // 插入
        $sql = "insert into employee(e_id, e_pwd, e_name) VALUES('$id', '$pwd', '$name')";
        mysqli_query($conn, $sql);
        // 注册成功
        $_SESSION["register_res"] = 'true';
        header("Location: ../login_register/login_register.php");
    }
    // 其他情况出错
    else {
        // 开启会话，然后向下一个页面传值
        $_SESSION["register_res"] = 'false';
        header("Location: ../login_register/login_register.php");
    }
}

// 登录
function login() {
    // 没有这两个值，直接结束
    if (!contains($_POST, Array('id', 'pwd'))) {
        return;
    }
    
    // 正常情况
    // 顾客跳转到个人主页
    if (cid_is_right($_POST['id'], $_POST['pwd'])) {
        // 设置cookie，用于之后的判断
        setcookie('c_id', $_POST['id'], null, "/");
        setcookie('c_pwd', $_POST['pwd'], null, "/");
        header("Location: ../customer/personal_center.php");
    }
    // 员工
    else if (eid_is_right($_POST['id'], $_POST['pwd'])) {
        // 设置cookie，用于之后的判断
        setcookie('e_id', $_POST['id'], null, "/");
        setcookie('e_pwd', $_POST['pwd'], null, "/");
        header("Location: ../employee/manager_system/mainUI.php");
    }
    // 错误账号
    else {
        // 向下一个页面传值
        $_SESSION["login_res"] = 'false';
        header("Location: ../login_register/login_register.php");
    }
}

// 充值
function top_up() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', 'increase_money')) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 进行充值
    $c_id = $_POST['c_id'];
    $increase_money = $_POST['increase_money'];
    $sql = "UPDATE customer SET c_money = c_money + $increase_money where c_id = '$c_id'";
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['top_up_res'] = 'true';       // 充值结果
    header("Location: ../customer/personal_center.php");
}

// 编辑资料
function edit_data() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "c_name", "c_sex", "c_address", "c_connect")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }
   
    // 获取相应的数据
    $c_id = $_POST['c_id'];
    $c_name = $_POST['c_name'];
    $c_sex = $_POST['c_sex'];
    $c_address = $_POST['c_address'];
    $c_connect = $_POST['c_connect'];
    // 更新
    $sql = 
    "UPDATE customer SET c_name='$c_name', c_sex='$c_sex', ".
    "c_address='$c_address', c_connect='$c_connect' ".
    "where c_id = '$c_id'";
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['edit_data_res'] = 'true';       // 充值结果
    header("Location: ../customer/personal_center.php");
}

// 加入到购物车
function add_to_purchaseCar() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "g_id", "buy_num")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 获取参数
    $c_id = $_POST['c_id'];
    $buy_num = $_POST['buy_num'];
    $g_id = $_POST['g_id'];

    // 判断库存是否不足
    $sql = "select g_number from storehouse where g_id = '$g_id'";
    $g_number = mysqli_fetch_assoc(mysqli_query($conn, $sql))['g_number'];
    if ($g_number < $buy_num) {
        // 库存不足，无法添加，直接返回
        $_SESSION['add_to_purchaseCar_res'] = 'false';       // 添加结果
        header("Location: ../customer/brwose_products.php");
        return;
    }
    
    // 正常情况
    // 购物车有这种商品，更新
    $sql = "select * from purchase_car where c_id='$c_id' and g_id='$g_id'";
    if (mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
        $sql = "UPDATE purchase_car SET buy_num = buy_num + $buy_num where c_id='$c_id' and g_id='$g_id'";
    } else {    
        $sql = "insert into purchase_car(c_id, buy_num, g_id) values('$c_id', $buy_num, '$g_id')";
    }
    // 更新
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['add_to_purchaseCar_res'] = 'true';       // 添加结果
    header("Location: ../customer/brwose_products.php");
}

// 删除购物车的商品
function delete_cdys() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "pc_ids", "delivery_fee", "tax_rate")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }
    
    $pc_ids = $_POST['pc_ids'];
    // 删除选中的购物车记录
    for ($i = 0; $i < count($pc_ids); $i++) {
        $pc_id = $pc_ids[$i];
        $sql = "DELETE FROM purchase_car WHERE pc_id='$pc_id'";
        mysqli_query($conn, $sql);
    }

    // 返回
    $_SESSION['delete_cdys'] = 'true';       // 添加结果
    header("Location: ../customer/purchase_car.php");
}

// 判断是否可以购买   失败的原因：库存不足，余额不足
function can_buy($c_id, $pc_ids, $delivery_fee, $tax_rate) {
    // 使用全局变量$conn
    global $conn;
    // 订单数量
    $order_num = count($pc_ids);

    // 判断库存
    $total_price = 0;   // 需要的总钱
    for ($i = 0; $i < $order_num; $i++) {
        $pc_id = $pc_ids[$i];

        // 获取购买数量和冰酒id
        $sql = "select g_id, buy_num from purchase_car where pc_id = '$pc_id'";
        $a_order = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $buy_num = $a_order['buy_num'];     // 购买数量
        $g_id = $a_order['g_id'];           // 冰酒id

        // 获取单价和库存
        $sql = "select g_price, g_number from storehouse where g_id = '$g_id'";
        $a_order = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $g_price = $a_order['g_price'];
        $g_number = $a_order['g_number'];
        
        // 计算总价
        $total_price += ($buy_num * $g_price);

        // 判断
        if ($buy_num > $g_number) {
            return "抱歉，库存不足，请减少购买数量或者过一段时间再购买┭┮﹏┭┮";
        }
    }

    // 获取余额
    $sql = "select c_money from customer where c_id = '$c_id'";
    $c_money = mysqli_fetch_assoc(mysqli_query($conn, $sql))['c_money'];

    // 判断总价是否小于余额
    $total_price = $total_price * (1 + $tax_rate) + $delivery_fee;

    if ($total_price > $c_money) {
        return "抱歉，余额不足，请先充值再购买┭┮﹏┭┮";
    }
    
    // 可以成功购买
    return true;
}

// 进行购买
function buy($c_id, $pc_ids, $each_delivery_fee, $tax_rate, $o_address, $o_connect) {
    // 使用全局变量$conn
    global $conn;
    // 订单数量
    $order_num = count($pc_ids);

    // 创建所有订单
    for ($i = 0; $i < $order_num; $i++) {
        // 获取商品id
        $pc_id = $pc_ids[$i];

        // 获取购买数量和冰酒id
        $sql = "select g_id, buy_num from purchase_car where pc_id = '$pc_id'";
        $a_order = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $buy_num = $a_order['buy_num'];     // 购买数量
        $g_id = $a_order['g_id'];           // 冰酒id

        // 获取单价
        $sql = "select g_price, g_number from storehouse where g_id = '$g_id'";
        $a_order = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $g_price = $a_order['g_price'];
        
        // 计算部分总价
        $part_total_price = $buy_num * $g_price * (1 + $tax_rate) + $each_delivery_fee ;

        // 订单创建
        $sql = 
        "INSERT INTO orders(".
        "c_id, o_connect, o_address, delivery_fee, g_id, ".
        "buy_num, e_id, o_time, o_state, total_price, tax_rate) VALUES (".
        "'$c_id', '$o_connect', '$o_address', $each_delivery_fee, '$g_id', ".
        "'$buy_num', 'e222', now(), '待发货', $part_total_price, $tax_rate)";
        mysqli_query($conn, $sql);

        // 客户余额减少，积分增加
        $increase_score = round($part_total_price * 0.1);
        $sql = "UPDATE customer SET c_money = c_money - $part_total_price, ".
        "c_score = c_score + $increase_score  where c_id = '$c_id'";
        mysqli_query($conn, $sql);

        // 从购物车中移除
        $sql = "DELETE FROM purchase_car WHERE pc_id='$pc_id'";
        mysqli_query($conn, $sql);

        // 冰酒减少
        $sql = "UPDATE storehouse SET g_number = g_number - $buy_num where g_id = '$g_id'";
        mysqli_query($conn, $sql);
    }
}

// 购买购物车的商品
function purchase_cdys() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "pc_ids", "delivery_fee", "tax_rate", 'o_address', 'o_connect')) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 获取所有参数
    $c_id = $_POST['c_id'];                     // 顾客id
    $pc_ids = $_POST['pc_ids'];                 // 购买的商品种类
    $delivery_fee = $_POST['delivery_fee'];     // 配送费
    $tax_rate = $_POST['tax_rate'];             // 税率
    $o_address = $_POST['o_address'];           // 配送地址
    $o_connect = $_POST['o_connect'];           // 联系电话
    
    // 判断是否可以购买
    $can_buy_res = can_buy($c_id, $pc_ids, $delivery_fee, $tax_rate);
    // 进行购买
    if ($can_buy_res === true) {
        // 订单数量，平均运费
        $order_num = count($pc_ids);
        // 购买
        buy($c_id, $pc_ids, $delivery_fee / $order_num, $tax_rate, $o_address, $o_connect);
        $_SESSION['purchase_cdys'] = '购买成功，正准备配送您的物件！(#^.^#)';
    } else {
        $_SESSION['purchase_cdys'] = $can_buy_res;
    }
    // 跳转
    header("Location: ../customer/purchase_car.php");
}

// 增加评论
function add_evalution() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "o_id", "g_evaluate")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 取出参数
    $o_id = $_POST['o_id'];
    $g_evaluate = $_POST['g_evaluate'];

    // 获取c_id、g_id和g_evaluate
    $sql = "select c_id, g_id from orders where o_id = '$o_id'";
    $a_order = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $c_id = $a_order['c_id'];
    $g_id = $a_order['g_id'];

    // 插入评论
    $sql = "INSERT into goods_evaluate(c_id, g_evaluate, g_id) values('$c_id', '$g_evaluate', '$g_id')";
    mysqli_query($conn, $sql);

    // 修改订单状态
    $sql = "UPDATE orders set o_state='已评价' where o_id = '$o_id'";
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['evaluate_res'] = 'true';       // 增加评论成功
    header("Location: ../customer/personal_center.php");
}

// 删除订单（并不是真的删除）
function delete_order() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "o_id")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 删除（更新deleted为true）
    $o_id = $_POST['o_id'];
    $sql = "UPDATE orders SET deleted='true' WHERE o_id='$o_id'";
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['delete_order_res'] = 'true';       // 充值结果
    header("Location: ../customer/personal_center.php");
}

// 确认收货
function confirm_receipt() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "o_id")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 修改订单状态
    $o_id = $_POST['o_id'];
    $sql = "UPDATE orders SET o_state='待评价' WHERE o_id='$o_id'";
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['confirm_receipt_res'] = 'true';       // 充值结果
    header("Location: ../customer/personal_center.php");
}

// 退款
function refund() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', "o_id")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 查找总价
    $o_id = $_POST['o_id'];
    $sql = "SELECT total_price from orders where o_id='$o_id'";
    $total_price = mysqli_fetch_assoc(mysqli_query($conn, $sql))['total_price'];
    // 将钱返回给客户
    $c_id = $_POST['c_id'];
    $sql = "UPDATE customer SET c_money = c_money + $total_price WHERE c_id = '$c_id'";
    mysqli_query($conn, $sql);

    // 修改订单状态
    $o_id = $_POST['o_id'];
    $sql = "UPDATE orders SET o_state='已退款' WHERE o_id='$o_id'";
    mysqli_query($conn, $sql);

    // 返回
    $_SESSION['refund_res'] = 'true';       // 退款结果
    header("Location: ../customer/personal_center.php");
}

// 添加聊天消息
function add_message() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', 'e_id', "message")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 获取相关信息
    $c_id = $_POST['c_id'];
    $c_pwd = $_POST['c_pwd'];
    $e_id = $_POST['e_id'];
    $message = $_POST['message'];
    // 添加
    $sql = "INSERT INTO connectm(c_id, e_id, sender, message, conn_time)".
    " VALUES('$c_id', '$e_id', 'customer', '$message', now())";
    mysqli_query($conn, $sql);

    // 返回
    header("Location: ../customer/message.php");
}

// 变成vip
function become_vip() {
    // 使用全局变量$conn
    global $conn;

    // 表单数据完全正确才能操作
    if (!contains($_POST, Array('c_id', 'c_pwd', 'consume_score', "consume_money", "buy_way")) ||
        !cid_is_right($_POST['c_id'], $_POST['c_pwd'])) {
        return;
    }

    // 获取所有参数
    $c_id = $_POST['c_id'];
    $consume_score = $_POST['consume_score'];
    $consume_money = $_POST['consume_money'];
    $buy_way = $_POST['buy_way'];

    // 获取余额和积分
    $sql = "SELECT c_money, c_score from customer where c_id='$c_id'";
    $a_cus = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $c_money = (float)($a_cus['c_money']);
    $c_score = (int)($a_cus['c_score']);

    $change_order = null;
    // 判断购买方式
    if ($buy_way == 'money') {
        // 余额不足
        if ($c_money < $consume_money) {
            $_SESSION['become_vip'] = "余额不足┭┮﹏┭┮";
            header("Location: ../customer/personal_center.php");
        } else {
            // 修改数据库
            $sql = "UPDATE customer SET c_money = c_money - $consume_money, level='vip' where c_id='$c_id'";
            mysqli_query($conn, $sql);
            // 返回
            $_SESSION['become_vip'] = "成功成为VIP，快去享受您的特权吧(*^▽^*)！";
            header("Location: ../customer/personal_center.php");
        }
    } else {
        // 积分不足
        if ($c_score < $consume_score) {
            $_SESSION['become_vip'] = "积分不足┭┮﹏┭┮";
            header("Location: ../customer/personal_center.php");
        } else {
            // 修改数据库
            $sql = "UPDATE customer SET c_score = c_score - $consume_score, level='vip' where c_id='$c_id'";
            mysqli_query($conn, $sql);
            // 返回
            $_SESSION['become_vip'] = "成功成为VIP，快去享受您的特权吧(*^▽^*)！";
            header("Location: ../customer/personal_center.php");
        }
    }
}




// 主函数
function main() {
    // 支持的所有服务如下：
    $login_register = '1';              // 注册和登录
    $top_up = '2';                      // 充值
    $edit_data = '3';                   // 编辑资料
    $add_to_purchaseCar = '4';          // 加入到购物车
    $delete_cdys = '5';                 // 删除购物车
    $add_evalution = '6';               // 增加评论
    $delete_order = '7';                // 删除订单（待评论和历史订单）
    $confirm_receipt = '8';             // 确认收货
    $refund = '9';                      // 退款
    $add_message = '10';                // 添加信息
    $become_vip = '11';                 // 变成vip







    // 获取操作码
    $op = null;
    if (isset($_GET['op'])) {
        $op = $_GET['op'];
    } else if (isset($_POST['op'])) {
        $op = $_POST['op'];
    }
    
    // 判断要进行的操作
    switch($op) {
        // 没有操作码直接跳回登录界面
        case null:
            header("Location: ../login_register.php");
        break;
        // 登录和注册
        case $login_register:   
            if (isset($_POST['whatButton']) && $_POST['whatButton']=='登录') {
                login();
            } else if (isset($_POST['whatButton']) && $_POST['whatButton']=='注册') {
                register();
            }
        break;
        // 充值
        case $top_up:
            top_up();
        break;
        // 编辑资料
        case $edit_data:
            edit_data();
        break;
        // 添加到购物车
        case $add_to_purchaseCar:
            add_to_purchaseCar();
        break;
        // 清除或购买购物车的物品
        case $delete_cdys:
            if (isset($_POST['whatButton']) && $_POST['whatButton']=='删除') {
                // 删除
                delete_cdys();
            } else if (isset($_POST['whatButton']) && $_POST['whatButton']=='购买') {
                // 购买
                purchase_cdys();
            }
        break;
        // 增加评论
        case $add_evalution:
            add_evalution();
        break;
        // 删除一个评论订单
        case $delete_order:
            delete_order();
        break;
        // 确认收货
        case $confirm_receipt:
            confirm_receipt();
        break;
        // 退款
        case $refund:
            refund();
        break;
        // 添加消息
        case $add_message:
            add_message();
        break;
        // 变成vip
        case $become_vip:
            become_vip();
        break;


    }
}

// 调用主函数
main();

?>







<!DOCTYPE html>  
<html>  
	<head>  
		<meta charset="UTF-8">  
		<title>服务器</title>  
		<style>
		</style>
	</head>

	<body>
        <?php 
           
            
        ?>
		
	</body> 
</html>
