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

?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>帮助</title>
        <style>
            body {
                text-align: center;
            }
            /*个人中心字体发亮*/
			#menu-item-4 {
				font-weight: bold;
				color: #F4606C;
				text-shadow: 0 0 2px;
			}
            <?php nav_css(); ?>     /* 菜单栏样式 */
            #help {
                display: inline-block;
                font-size: 25px;
                font-family: KaiTi;
                text-align: left;
                line-height: 2.0;
            }
        </style>
    </head>
    <body>
       <?php
           nav();   // 导航
        ?>
        <p id='help'>
        遇到了问题？看看下面有没有您想要的解决方案：<br>
        （1）...<br>
        （2）...<br>
        （3）...<br>
        （4）...<br>
        </p>
    </body>
</html>
