<!--商品浏览-->
<?php
// 网站根目录
$root_dir = $_SERVER['DOCUMENT_ROOT']."/icewine";

// cookie的相关操作
include("$root_dir/customer/verify/verify.php");
// 验证操作
judge_cookie();

// 开启会话，用于传数据
session_start();

// 连接到数据库
include("$root_dir/conn.php");
// 加载菜单栏
include("./ele/menu.php");

// 运费和税率设为全局变量（为了给js传值）
$delivery_fee = null;
$tax_rate = null;

// 显示购物车中的一种商品
function disp_a_cdy($a_PcRecord) {
    // 使用全局变量$conn
    global $conn;

    // 获取商品详情
    $g_id = $a_PcRecord['g_id'];
    $sql = "select * from storehouse where g_id='$g_id'";
    $a_cdyRecord = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    
    // 显示所需的信息
    $g_name = $a_cdyRecord['g_name'];           // 冰酒名
    $g_price = $a_cdyRecord['g_price'];         // 冰酒单价
    $img_path = "./ice_wine_imgs/$g_name.jpg";  // 图片路径
    $buy_num = $a_PcRecord['buy_num'];          // 购买数量
    $total_price = $g_price * $buy_num;         // 总价格
    $pc_id = $a_PcRecord['pc_id'];             // 该种商品购买时的id
    // 用一个div进行显示
    echo
    "<div class='a-cdy'>".
        "<input type='checkbox' name='pc_ids[]' value='$pc_id' onclick='checkbox_onClick(this)'>".
        "<div class='a-cdy-img'><img src='$img_path' height='200px'></div>".
        "<div class='a-cdy-content'>".
            "冰酒名称：$g_name<br>".
            "冰酒价格：$g_price<br>".
            "购买数量：$buy_num<br>".
            "总价格：<span class='part-total-price'>$total_price</span><br>".
        "</div>".
    "</div>";
}

// 显示所有购物车中的商品
function disp_all_cdys() {
    // 使用全局变量$conn
    global $conn;

    // 获取所有记录
    $c_id = $_COOKIE['c_id'];
    $sql = "select * from purchase_car where c_id = '$c_id'";
    $all_PcRecords = mysqli_query($conn, $sql);
    // 表单
    echo "<form action='../server/server.php?op=5' method='POST' id='cdys-form'>";
    echo "<div id='left'>";      // 左边部分开始

    // 商品显示区（遍历所有记录）
    echo "<div id='disp-cdys'>";
    while ($a_PcRecord = mysqli_fetch_assoc($all_PcRecords)) {
        disp_a_cdy($a_PcRecord);
    }
    echo "</div>";
    // 获取默认地址和电话
    $sql = "select * from customer where c_id = '$c_id'";
    $a_cus = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $default_o_address = $a_cus['c_address'];
    $default_o_connect = $a_cus['c_connect'];
    // 地址和电话显示
    echo    
    "<div id='address-tel'>".
        "配送地址：<input type='text' name='o_address' value='$default_o_address' required='required' maxlength='25'><br>".
        "联系电话：<input type='text' name='o_connect' value='$default_o_connect' required='required' maxlength='15'><br>".
    "</div>";

    echo "</div>";           // 左边部分结束

    // 额外费用显示区和提交按钮
    global $delivery_fee;
    global $tax_rate;
    $sql = "select level from customer where c_id = '$c_id'";
    $level = mysqli_fetch_assoc(mysqli_query($conn, $sql))['level'];
    $delivery_fee = ($level == 'vip'? 0.00: 20.00);      // 运费:VIP为0，普通用户20
    $tax_rate = 0.1;                                // 税率设为0.1
    
    echo "<div id='right'>";    // 右边区域开始
    echo 
    "<div id='extra-money-disp'>".
        "运费：0.00<br>".
        "税率：".number_format($tax_rate * 100, 2)."%<br>".
        "总价：0.00<br>".
    "</div>".
    "<div id='two-buttons'>".
        "<input type='submit' id='submit-button' name='whatButton' value='购买'>".
        "<div id='submit-button-disable'></div><br><br><br>". // 让按钮失效
        "<input type='submit' id='delete-button' name='whatButton' value='删除'>".
        "<div id='delete-button-disable'></div>". // 让按钮失效
    "</div>";
    echo "</div>";      // 右边区域结束

    // 将所有数据传送到服务器
    $c_pwd = $_COOKIE['c_pwd'];
    echo
    "<input type='hidden' name='c_id' value='$c_id'>".
    "<input type='hidden' name='c_pwd' value='$c_pwd'>".
    "<input type='hidden' name='delivery_fee' value='$delivery_fee'>".
    "<input type='hidden' name='tax_rate' value='$tax_rate'>".
    "</form>";
}

?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>我的购物车</title>
        <style>
            /*个人中心字体发亮*/
			#menu-item-2 {
				font-weight: bold;
				color: #F4606C;
				text-shadow: 0 0 2px;
			}
            /*冰酒 */
            body {
                text-align: center;
                background-color: #e9ecef;
            }
            form {
                display: inline-block;
                text-align: left;
                width: 1000px;
                height: 630px;
                margin-top: 20px;
                position: relative;
            }
            .a-cdy {
                position: relative;
                border-style: dashed;
                border-width: 2px;
                border-color: gray;
                padding: 10px;
                background-color: white;
            }
            .a-cdy-img {
                display: inline-block;
                height: 200px;
            }
            .a-cdy-content {
                position: absolute;
                font-family: KaiTi;
        		font-size: 25px;
                display: inline-block;
                line-height: 2.0;
                left: 180px;
            }
            /*复选框 */
            input[type='checkbox'] {
                width: 25px;
                height: 25px;
                position: absolute;
                right: 30px;
                top: 10px;
            }
            /*显示商品区域 */
            #disp-cdys {
                height: 456px;
                overflow-y: auto;
                border-style: solid;
                border-width: 2px;
                border-color: gray;
            }

            /*配送地址和联系电话 */
            #address-tel {
                font-family: KaiTi;
        		font-size: 25px;
                line-height: 2.5;
                padding-top: 20px;
                padding-bottom: 20px;
                text-align: center;
                border-style: solid;
                border-width: 2px;
                border-color: gray;
            }
            input[type='text'] {
                font-size: inherit;
                font-family: inherit;
                height: 40px;
                width: 400px;
                padding-left: 10px;
            }

            /*额外费用显示区 */
            #extra-money-disp {
                font-family: KaiTi;
        		font-size: 25px;
                line-height: 1.8;
                text-align: left;
                display: inline-block;
                margin-top: 100px;
            }
            #two-buttons {
                display: inline-block;
                margin-top: 100px;
                position: relative;
            }
            #submit-button, #delete-button {
                font-family: KaiTi;
        		font-size: 25px;
                height: 50px;
                padding-left: 50px;
                padding-right: 50px;
                color: gray;
                letter-spacing: 13px;
            }
            #submit-button:hover, #delete-button:hover {
                font-weight: bold;
                cursor: pointer;
            }
            #submit-button-disable, #delete-button-disable {
                display: block;
      			position: absolute;
                width: 180px;
                height: 50px;
                background-color: black;
                right: 0;
                top: 18%;
                margin-top: -25px;
                z-index:1001;
				-moz-opacity: 0.8;
				opacity:.20;
            }
            #delete-button-disable {
                top: 82%;
            }
            #left {
                display: inline-block;
                width: 700px;
                position: absolute;
                left: 0;
                margin-bottom: 50px;
            }
            #right {
                text-align: center;
                border-style: solid;
                border-width: 2px;
                border-color: #F4606C;
                padding: 20px;
                position: relative;
                height: 585px;
                width: 260px;
                display: inline-block;
                position: absolute;
                right: -2px;
            }

            <?php nav_css(); ?>     /* 菜单栏样式 */
        </style>
    </head>
    <body>
        <?php
            // 删除结果
            if (isset($_SESSION['delete_cdys']) && $_SESSION['delete_cdys'] == 'true') {
                echo "<script> alert('删除成功！'); </script>";
                // 清除结果
                unset($_SESSION["delete_cdys"]);
            }
            // 购买结果
            if (isset($_SESSION['purchase_cdys'])) {
                echo "<script> alert('".$_SESSION['purchase_cdys']."'); </script>";
                // 清除结果
                unset($_SESSION["purchase_cdys"]);
            }
            nav();     // 菜单栏
            disp_all_cdys();
        ?>
    </body>
    <!--js-->
    <script>
        // 后退时页面也刷新
        if(window.name != "refresh"){
            location.reload();
            window.name = "refresh";
        }
        else{
            window.name = "";
        }

        <?php
            // php传值到js
            echo "var delivery_fee = $delivery_fee;";     // 运费
            echo "var tax_rate = $tax_rate;";             // 税率
        ?>
        var total_price = 0.0;    // 总价格

        // 复选框被选中的事件
        function checkbox_onClick(checkbox) {
            // 获取价格
            part_total_price = Number(checkbox.parentNode.lastChild.getElementsByClassName('part-total-price')[0].innerHTML);
            // 修改文字
            if (checkbox.checked == true) {
                total_price += part_total_price;
            } else {
                total_price -= part_total_price;
            }
            // 用于显示的运费，没选中东西时是0，否则是php传入的运费
            var disp_delivery_fee = (total_price <= 0? 0: delivery_fee);
            // 如果总价是0，无法下单购买，所以让按钮无法点击，字体设为灰色
            if (total_price <= 0) {
                // 提交按钮不可点击
                document.getElementById('submit-button-disable').style.display = 'block';
                document.getElementById('submit-button').style.color = 'gray';
                // 删除按钮不可点击
                document.getElementById('delete-button-disable').style.display = 'block';
                document.getElementById('delete-button').style.color = 'gray';
            } else {
                document.getElementById('submit-button-disable').style.display = 'none';
                document.getElementById('submit-button').style.color = 'black';
                document.getElementById('delete-button-disable').style.display = 'none';
                document.getElementById('delete-button').style.color = 'black';
            }

            // 修改文字
            document.getElementById("extra-money-disp").innerHTML = 
                "运费：" + disp_delivery_fee.toFixed(2) + "<br>" +   // 保留两位小数
                "税率：" + (tax_rate * 100).toFixed(2) + "%<br>" +
                "总价：" + (total_price * (1 + tax_rate) + disp_delivery_fee).toFixed(2) + "<br>";
        }
    </script>
</html>



