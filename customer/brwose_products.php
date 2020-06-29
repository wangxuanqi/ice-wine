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

// 展示一个商品
function show_mcd($aRecord) {
    // 使用全局变量$conn
    global $conn;

    echo "<td valign='bottom' class='big-table-cell'>";    // 下端对齐
    // 设置图片
    $img_path = "./ice_wine_imgs/".$aRecord['g_name'].".jpg";
    echo "<img src='$img_path' width='230px'>";

    // 只允许输入数字
    $only_input_number = " onkeyup=\"value=value.replace(/[^\d]/g,'') \" onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))\" ";

    // 表单信息
    echo 
    "<div id='buy-form-fa'><form action='../server/server.php?op=4' method='post' id='buy-form'>".
    "<input type='hidden' name='c_id', value='".$_COOKIE['c_id']."'>".
    "<input type='hidden' name='c_pwd', value='".$_COOKIE['c_pwd']."'>".
    "<input type='hidden' name='g_id' value='".$aRecord['g_id']."'>".
    "<p>购买数量：<input type='number' name='buy_num' min='1' value='1' class='en-text' $only_input_number></p>".
    "<input type='submit' value='加入到购物车'>".
    "</form></div>";

    // 再用表格显示相关信息
    echo 
    "<table class='small-table' align='center'><tbody>".
    "<tr><td class='small-table-cell'>名称</td><td class='small-table-cell'>".$aRecord['g_name']."</td></tr>".
    "<tr><td class='small-table-cell'>价格</td><td class='small-table-cell en-text'>￥".$aRecord['g_price']."</td></tr>".
    "<tr><td class='small-table-cell'>规格</td><td class='small-table-cell en-text'>".$aRecord['Specifications']."ML</td></tr>".
    "<tr><td class='small-table-cell'>库存</td><td class='small-table-cell en-text'>".$aRecord['g_number']."</td></tr>".
    "<tr><td class='small-table-cell'>生产日期</td><td class='small-table-cell en-text'>".$aRecord['g_birth']."</td></tr>".
    "<tr><td class='small-table-cell'>保质期</td><td class='small-table-cell'><span class='en-text'>".$aRecord['g_qperiod']."</span>个月</td></tr>".
    "</tbody></table>";
    // 大表格的结束符
    echo "</td>";


    echo
    "<td class='disp-all-reviews big-table-cell'>".
    "<h1>评论区</h1>"; // 标题
    // 获取所有评论
    $g_id = $aRecord['g_id'];
    $sql = "SELECT * FROM goods_evaluate where g_id = '$g_id'";
    $all_evaluations = mysqli_query($conn, $sql);
    // 遍历评论
    while ($a_evaluation = mysqli_fetch_assoc($all_evaluations)) {
        // 获取评论者的名字
        $c_id = $_COOKIE['c_id'];
        $sql = " SELECT c_name FROM customer where c_id='$c_id'";
        $c_name = mysqli_fetch_assoc(mysqli_query($conn, $sql))['c_name'];
        // 获取评论内容
        $review_content = $a_evaluation['g_evaluate'];
        // 显示评论
        echo "<p class='disp-a-review'>$c_name"."：$review_content</p>";
    }

    "</td>";
}

// 展示所有商品
function show_products() {
    global $conn;
    
    // 获取所有记录
    $sql = "select * from storehouse";
    $allRecords = mysqli_query($conn, $sql);

    // 遍历记录，然后进行显示
    // 通过表格进行显示
    echo "<table align='center' class='big-table'><tbody>";
    while ($aRecord = mysqli_fetch_assoc($allRecords)) {
        echo "<tr>";
        show_mcd($aRecord);
        echo "</tr>";
    }
    echo "</table></tbody>";
}

?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>浏览商品</title>
        <style>
            body {
                background-color: #e9ecef;
            }
            .big-table {
                border-spacing: 0 50px;
            }
            tr: first-child {
                border-spacing: 100px 0;
            }
            .big-table-cell {
                text-align: center;
                border-style: dashed;
                border-width: thin;
                border-color: gray;
                border-radius: 15px;
                padding: 0 50px 20px 50px;
                background-color: white;
                font-family: KaiTi;
                font-size: 25px;
                height: 700px;
            }
            .small-table {
                border-style: solid;	/*实线*/
                border-width: thin;
                border-collapse: collapse;  /*直接消除单元格之间的距离*/
                margin-top: 20px;
            }
            .small-table-cell {
                text-align: center;
                border-style: dashed;
                border-width: thin;
                border-color: gray;
                padding: 15px 30px;
		    }
            .en-text {
                font-family: FZShuTi;
                font-size: 25px;
            }
            input[type='number'] {
                width: 80px;
                height: 30px;
                font-size: 30px;
            }
            select {
                font-size: 25px;
                font-family: FZShuTi;
                height: 30px;
            }
            input[type='submit'] {
                font-size: 25px;
                font-family: KaiTi;
                width: 200px;
                height: 50px;
                text-align: center;
                border-radius: 5px;
                margin: 30px auto;
            }
            input[type='submit']:hover {
                font-weight: bold;
                cursor: pointer;
            }
            #buy-form-fa {
                display: inline-block;
                position: relative;
                width: 220px;
                height: 328px;
            }
            #buy-form {
                display: inline-block;
                position: absolute;
                right: -10%;
                top: 50%;
                margin-top: -78px;
            }
            input[type='number'] {
                text-align: center;
            }
            /*评论显示区*/
            h1 {
                margin: 10px auto 20px auto;
                text-align: center;
                font-size: 30px;
            }
            .disp-all-reviews {
                display: inline-block;
                width: 600px;
                height: 720px;
                text-align: left;
                overflow-y: auto;
                padding: 0;
            }
            .disp-a-review { 
                word-break: break-all;
                margin: 0;
                font-size: 25px;
                padding: 5px 10px 5px 10px;
                border-style: dashed;
                border-width: 1px;
                border-color: gray;
                border-radius: 10px;
                margin-bottom: 10px;
            }

            /*个人中心字体发亮*/
			#menu-item-0 {
				font-weight: bold;
				color: #F4606C;
				text-shadow: 0 0 2px;
			}
            <?php nav_css(); ?>     /* 菜单栏样式 */
        </style>
    </head>
    <body>
       <?php
            nav();     // 菜单栏
            // 显示商品
            show_products();
            // 添加成功
            if (isset($_SESSION['add_to_purchaseCar_res'])) {
                if ($_SESSION['add_to_purchaseCar_res'] == 'true') {
                    echo "<script> alert('添加成功，继续购物吧(*^▽^*)！'); </script>";
                } else if ($_SESSION['add_to_purchaseCar_res'] == 'false') {
                    echo "<script> alert('库存不足，无法添加┭┮﹏┭┮'); </script>";
                }
                // 清除结果
                unset($_SESSION["add_to_purchaseCar_res"]);
            }
        ?>
    </body>
</html>
