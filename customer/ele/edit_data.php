<?php

// 信息填写表
function edit_data() {
    // 和个人主页的联系变量
    $id = "edit_data";       // 编辑资料的id
    // 使用全局变量（一个客户对象）
    global $a_cus;

    // 每一个填写项的信息
    $input_types = Array("text", "select", "text", "tel");
    $item_names = Array("用户名称：", "性&emsp;&emsp;别：", "地&emsp;&emsp;址：", "联系方式：");
    $item_old_values = Array($a_cus['c_name'], $a_cus['c_sex'], $a_cus['c_address'], $a_cus['c_connect']);
    // 用于传值 
    $item_keys = Array("c_name", "c_sex", "c_address", "c_connect");
    // 总数目
    $item_num = count($item_names);

    $c_id = $a_cus['c_id'];
    $c_pwd = $a_cus['c_pwd'];
    // 构造填写表
    echo 
    "<div id='$id'>".
    "<a id='close' onclick='close_$id()'></a>".
    "<form action='../server/server.php?op=3' method='post' id='$id-form'>".
        "<input type='hidden' name='c_id' value='$c_id'>".
        "<input type='hidden' name='c_pwd' value='$c_pwd'>";
    for ($i = 0; $i < $item_num; $i++) {
        // 用于显示
        $type = $input_types[$i];
        $item_name = $item_names[$i];        
        $old_value = $item_old_values[$i];
        // 用于传值
        $key = $item_keys[$i];

        // 输出成一行
        echo 
        "<div class='tableRow'>".
            "<p class='tableCell'>$item_name</p>";
        // 选择器区别对待
        echo "<p class='tableCell'>";
        if ($type == "select") {
            $man_selected = $woman_selected = "";
            // 判断是否是男性
            if ($old_value == '男') {
                $man_selected = " selected = 'selected' ";
            } else {
                $woman_selected = " selected = 'selected' ";
            }
            echo
            "<select name='$key'>".
                "<option $man_selected>男</option>".
                "<option $woman_selected>女</option>"."
            </select>";
        } else {
            echo 
            "<input type='$type' name='$key' value='$old_value'>";
        }
        echo "</p>";
        // 结束符
        echo
        "</div>";
    }
    // 添加提交按钮
    $submit_id = $id."_submit";
    echo "<div class='tableRow'><input type='submit' value='确定修改' id='$submit_id' class='kaiti25'></div>";
    echo "</form></div>";
}

// 样式
function edit_data_css() {
    // 和个人主页的联系变量
    $id = "edit_data";         // 编辑资料的id
    // 提交按钮的id
    $submit_id = $id."_submit";

    echo "
    .tableRow {
        display: table-row;
    }
    .tableCell {
        display: table-cell;
        padding: 15px;
        font-family: KaiTi;
        font-size: 25px;
    }
    .tableCell:first-child {
        text-align: right;
    }
    .tableCell:last-child {
        text-align: left;
    }
    #$id-form {
        display: inline-block;
        border-color: #7e7e7e;
        padding: 10px;
        padding-left: 0;
        margin: 50px 5px 5px 5px;
    }
    input, select {
        font-family: inherit;
        font-size: inherit;
        height: 40px;
    }
    #$submit_id {
        width: 150px;
        height: 50px;
        margin: auto 100%;
        margin-top: 30px;
        margin-bottom: 10px;
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
        width: 480px;
        margin-left: -240px;
        background-color: white;
        display:none;   /*一开始是隐藏状态*/
        z-index:1002;
        overflow: auto;
        margin-bottom: 0;
        border-radius: 2%;
    }
    ";
}
?>