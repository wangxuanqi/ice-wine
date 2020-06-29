<?php

$consume_score = 10000;     // 购买所需积分
$consume_money = 100;       // 购买所需钱

// vip充值界面
function become_vip() {
    // 和个人主页的联系变量
    $id = "become_vip";
    // 使用全局变量（一个客户对象）
    global $a_cus, $consume_score, $consume_money;

    $c_id = $a_cus['c_id'];
    $c_pwd = $a_cus['c_pwd'];

    // 构造购买表
    echo 
    "<div id='$id'>".
    "<a id='close' onclick='close_$id()'></a>".
    "<form action='../server/server.php?op=11' method='post' id='$id-form'>".
        // 选择购买方式
        "<div id='tips'>".
        "购买会员需要可以选择以下两种方式：<br>".
        "（1）通过积分进行购买，需花费$consume_score"."积分<br>".
        "（2）通过余额进行购买，需花费¥$consume_money<br><br>".
        "</div>".
        "<select name='buy_way' id='buy_way-select' class='kaiti25'>".
            "<option value='score' class='kaiti25'>积分购买</option>".
            "<option value='money' class='kaiti25'>余额购买</option>".
        "</select>".
        "<input type='hidden' name='consume_score' value='$consume_score'>".
        "<input type='hidden' name='consume_money' value='$consume_money'>".
        "<input type='hidden' name='c_id' value='$c_id'>".
        "<input type='hidden' name='c_pwd' value='$c_pwd'>";
    
    // 添加提交按钮
    $submit_id = $id."_submit";
    echo "<br><input type='submit' value='确定修改' id='$submit_id' class='kaiti25'>";
    echo "</form></div>";
}

// 样式
function become_vip_css() {
    // 和个人主页的联系变量
    $id = "become_vip";         // 编辑资料的id
    // 提交按钮的id
    $submit_id = $id."_submit";

    echo "
    #$id-form {
        display: inline-block;
        border-color: #7e7e7e;
        padding: 10px;
        padding-left: 0;
        margin: 50px 5px 5px 5px;
    }
    #tips {
        display: inline-block;
        font-family: KaiTi;
        font-size: 25px;
        text-align: left;
    }
    input, select {
        font-family: inherit;
        font-size: inherit;
        height: 40px;
    }
    #$submit_id {
        width: 150px;
        height: 50px;
        display: inline-block;
        margin-top: 30px;
        margin-bottom: 20px;
    }
    #$submit_id {
        cursor: pointer;
    }
    #close {
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 40px;
        background: url(icons/close.png) no-repeat;
        background-size: 40px 40px;
        text-align: center;
    }
    #close:hover {
        cursor: pointer;
    }
    #$id {
        position: absolute;
        top: 20%;
        left: 50%;
        width: 550px;
        margin-left: -275px;
        background-color: white;
        display:none;   /*一开始是隐藏状态*/
        z-index:1002;
        overflow: auto;
        margin-bottom: 0;
        border-radius: 2%;
        text-align: center;
    }
    ";
}
?>