<?php

// 信息填写表
function top_up() {
    // 和个人主页的联系变量
    $id = "top_up";       // 充值的id
    // 只允许输入数字
    $only_input_number = " onkeyup=\"value=value.replace(/[^\d]/g,'') \" onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))\" ";

    // 使用全局变量
    global $a_cus;
    $c_id = $a_cus['c_id'];
    $c_pwd = $a_cus['c_pwd'];

    // 表单的id
    $form_id = $id."_submit";
    // 提交按钮的id
    $submit_id = $id."_submit";
    // 构造填写表
    echo 
    "<div id='$id'>".
        "<a id='close' onclick='close_$id()'></a>".
        "<form action='../server/server.php?op=2' method='post' class='kaiti25' id='$form_id'>".
            "充值金额：<input type='text' name='increase_money' $only_input_number class='kaiti25' id='input-money' maxlength='4'><br>".
            "<input type='submit' value=充&emsp;值 id=$submit_id class='kaiti25'>".
            "<input type='hidden' name='c_id' value='$c_id'>".
            "<input type='hidden' name='c_pwd' value='$c_pwd'>".
        "</form>".
    "</div>";
}

// 样式
function top_up_css() {
    // 和个人主页的联系变量
    $id = "top_up";       // 充值的id
    // 表单的id
    $form_id = $id."_submit";
    // 提交按钮的id
    $submit_id = $id."_submit";

    echo "
    /*表单*/
    #$submit_id {
        display: inline-block;
        margin: 20px auto 10px auto;
    }
    #$form_id {
        margin: 25px;
    }
    #input-money {
        width: 100px;
    }
    #$id {
        position: absolute;
        top: 30%;
        left: 50%;
        width: 480px;
        height: 170px;
        margin-left: -240px;
        background-color: white;
        display:none;   /*一开始是隐藏状态*/
        z-index:1002;
        overflow: auto;
        margin-bottom: 0;
        border-radius: 2%;
        text-align: center;
        overflow-x: hidden;    
        overflow-y: hidden;  
    }
    ";
}
?>