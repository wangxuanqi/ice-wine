<?php

// 显示一个历史订单
function disp_a_order_history($a_order) {
    // 使用全局变量$conn和一个客户对象
    global $conn, $a_cus;

    $c_id = $a_cus['c_id'];
    $c_pwd = $a_cus['c_pwd'];

    // 显示所需的信息
    $o_id = $a_order['o_id'];                       // 订单号
    $delivery_fee = $a_order['delivery_fee'];       // 配送费
    $tax_rate = $a_order['tax_rate'];               // 税率
    $total_price = $a_order['total_price'];         // 总价钱
    $buy_num = $a_order['buy_num'];                 // 购买数量 
    $o_address = $a_order['o_address'];             // 配送地址
    $o_connect = $a_order['o_connect'];             // 联系电话
    $o_time = $a_order['o_time'];                   // 下单时间
    $g_total_fee = (($total_price - $delivery_fee) / (1 + $tax_rate));   // 商品总价钱
    // 获取商品名称
    $g_id = $a_order['g_id'];       // 商品id
    $sql = "select g_name from storehouse where g_id = '$g_id'";
    $g_name = mysqli_fetch_assoc(mysqli_query($conn, $sql))['g_name'];

    // 图片路径
    $img_path = "./ice_wine_imgs/$g_name.jpg";

    // 用一个div进行显示
    echo
    "<div class='a-order_history'>".
        "<div class='a-order_history-img'><img src='$img_path' height='200px'></div>".
        "<div class='a-order_history-content-left'>".
            "订单号：$o_id<br>".
            "冰酒名称：$g_name<br>".
            "购买数量：$buy_num<br>".
            "联系电话：$o_connect<br>".
            "配送地址：$o_address<br>".
        "</div>".
        "<div class='a-order_history-content-right'>".
            "下单时间：$o_time<br>".
            "冰酒总价：$g_total_fee<br>".
            "税率：".($tax_rate * 100)."%<br>".
            "配送费用：$delivery_fee<br>".
            "总费用：$total_price<br>".
        "</div>".
        "<form action='../server/server.php?op=7' method='POST' id='delete_order_history-form'>".  // 删除
            "<input type='submit' value='删&nbsp;除' id='delete_order_history'>".
            "<input type='hidden' name='c_id' value='$c_id'>".
            "<input type='hidden' name='c_pwd' value='$c_pwd'>".
            "<input type='hidden' name='o_id' value='$o_id'>".
        "</form>".
    "</div>";
}

// 显示所有订单
function disp_all_order_history() {
    // 使用全局变量$conn和$c_id
    global $conn, $c_id;

    // 查出所有的待发货订单
    $sql = "select * from orders where c_id = '$c_id' and o_state='已评价' and deleted='false'";
    $all_orders = mysqli_query($conn, $sql);
    
    // 商品显示区（遍历所有记录）
    echo "<div id='disp-order_history'>";
    echo "<p id='title'>所有的历史订单如下：</p>";
    while ($a_order = mysqli_fetch_assoc($all_orders)) {
        disp_a_order_history($a_order);
    }
    echo "</div>";
}

// 历史订单
function order_history() {
    // 和个人主页的联系变量
    $id = "order_history";       // 历史订单的id
    // 使用全局变量（一个客户对象）
    global $a_cus;

    
    $c_id = $a_cus['c_id'];
    $c_pwd = $a_cus['c_pwd'];
    // 构造填写表
    echo "<div id='$id'>";
        disp_all_order_history();  // 显示所有历史订单
        echo "<a id='close' onclick='close_$id()'></a>";
    echo "</div>";
}

// 样式
function order_history_css() {
    // 和个人主页的联系变量
    $id = "order_history";         // 历史订单的id

    echo "
    #title {
        font-family: KaiTi;
        font-size: 30px;
        font-weight: bold;
        text-align: center;
        margin-top: 0;
        margin-bottom: 20px;
    }

    #$id {
        /*位置控制*/
        width: 1100px;
        height: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -550px;
        margin-top: -250px;
        /*其他控制*/
        display:none;   /*一开始是隐藏状态*/
        z-index:1002;
        overflow: auto;
        border-radius: 2%;
        padding: 20px;
        background-color: white;
    }
    /*显示订单*/
    .a-order_history {
        position: relative;
        border-style: dashed;
        border-width: 2px;
        border-color: gray;
        padding: 10px 10px 10px 20px;
        background-color: white;
    }
    .a-order_history-img {
        display: inline-block;
    }
    .a-order_history-content-left, .a-order_history-content-right {
        display: inline-block;
        font-family: KaiTi;
        font-size: 25px;
        line-height: 1.8;
    }
    .a-order_history-content-left {
        width: 450px;
        margin-left: 50px;
    }
    /*退款按钮*/
    #delete_order_history {
        font-family: KaiTi;
        font-size: 20px;
        background-color: white;
        border-radius: 15px;
        cursor: pointer;
    }
    #delete_order_history:hover {
        font-weight: bold;
    }
    #delete_order_history-form {
        display: inline-block;
        position: absolute;
        bottom: 10px;
        right: 20px;
    }
    ";
}
?>