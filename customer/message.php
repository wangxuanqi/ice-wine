<!--与客服进行聊天-->
<?php
// 网站根目录
$root_dir = $_SERVER['DOCUMENT_ROOT']."/icewine";

// cookie的相关操作
include("$root_dir/customer/verify/verify.php");
// 验证操作
judge_cookie();

// 获取这个顾客
include("$root_dir/conn.php");
$c_id = $_COOKIE['c_id'];
$sql = "select * from customer where c_id = '$c_id'";
$a_cus = mysqli_fetch_assoc(mysqli_query($conn, $sql));

// 加载菜单栏
include("./ele/menu.php"); 

// 客服工号
$e_id = "e111";  

// 对方信息
function emp_inf() {
    // 使用全局变量$conn和客户工号
    global $conn, $e_id;
    
    // 获取详细信息
    $sql = "SELECT * from employee where e_name='客户本服'";
    $a_emp = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $e_name = $a_emp['e_name'];                 // 名字
    $e_connect = $a_emp['e_connect'];           // 电话
    $img_path = "./head-portrait/emp.jpg";      // 头像路径

    // 显示咨询员信息
    echo
    "<div id='emp'>".
        "<img src='$img_path' class='head-portrait' width=80px height=80px>".
        "<p id='emp-inf'>$e_name(联系电话：$e_connect)</p>".
    "</div>";
}


// 显示所有聊天记录
function all_contents() {
    // 使用全局变量$conn
    global $conn;

    // 两个人的头像路径
    $e_img_path = "./head-portrait/emp.jpg";
    $c_img_path = "./head-portrait/hui.jpg";

    // 获取所有消息（按时间排序）
    $c_id = $_COOKIE['c_id'];
    $sql = "SELECT * from connectm where c_id='$c_id' GROUP BY conn_time, conn_id";
    $all_messages = mysqli_query($conn, $sql);

    // 遍历所有消息
    echo "<div id='display-contents'>";
    while ($a_message = mysqli_fetch_assoc($all_messages)) {
        $message = $a_message['message'];           // 内容
        $sender = $a_message['sender'];             // 发送者
        $conn_time = $a_message['conn_time'];       // 发送时间

        // 自己放右边
        if ($sender=='customer') {
            echo 
            "<p class='c2e-time'>$conn_time</p>".
            "<div class='c2e'>".
                "<div class='c2e-content'>$message</div>".
                "<img src='$c_img_path' class='head-portrait' width=80px height=80px>".
            "</div>";
        }
        // 对方放左边
        else {
            echo 
            "<p class='e2c-time'>$conn_time</p>".
            "<div class='e2c'>".
                "<img src='$e_img_path' class='head-portrait' width=80px height=80px>".
                "<div class='e2c-content'>$message</div>".
            "</div>";
        }
    }
    echo "</div>";
}

// 消息输入区
function input_text() {
    // 使用全局变量$conn和一个客户对象
    global $conn, $a_cus, $e_id;

    $c_id = $a_cus['c_id'];
    $c_pwd = $a_cus['c_pwd'];

    echo
    "<div id='input-text'>".
        "<form action='../server/server.php?op=10' method='post'>".
            "<textarea name='message' required='required' maxlength=100></textarea>".
            "<div id='tips'>(每条消息最多100个字)</div>".
            "<br><br><input type='submit' value='发&emsp;送'><br><br>".
            "<input type='hidden' name='e_id' value='$e_id'>".
            "<input type='hidden' name='c_id' value='$c_id'>".
            "<input type='hidden' name='c_pwd' value='$c_pwd'>".
        "</form>".
    "</div>";
}


// 显示聊天界面
function chat_frame() {
    // 聊天窗体区域
    echo "<div id='chat'>";

    // 显示客服信息
    emp_inf();
    // 显示所有聊天记录
    all_contents();
    // 输出框
    input_text();

    echo "</div>";
}




?>


<!DOCTYPE html>  
<html>  
	<head>  
		<meta charset="UTF-8">  
		<title>消息中心</title>  
		<style>
			<?php 
                nav_css(); 		    // 导航栏样式
			?>
			body {
				margin: 0;
				
			}
			/*消息发亮*/
			#menu-item-1 {
				font-weight: bold;
				color: #F4606C;
				text-shadow: 0 0 2px;
			}
            /*chat窗体 */
            #chat {
                position: absolute;
                left: 50%;
                margin-left: -450px;
                background-color: #F3F4F5;
                top: 12%;
            }
            #emp {
                position: relative; 
                width: 900px;
                height: 80px;
                border-style: solid;
                border-width: thick;
                border-color: gray;
            }
            #emp-inf {
                display: inline-block;
                position: absolute;
                top: 1.2em;
                left: 4em;
                margin: 0;
                font-family: KaiTi;
                font-size: 22px;
                font-weight: bold;
            }
            .head-portrait {
                border-radius: 5%;
            }
            /*聊天记录*/
            #display-contents {
                width: 900px;
                height: 300px;
                border-style: solid;
                border-width: thick;
                border-color: gray;
                position: relative;
                overflow-y: auto;
            }
            .c2e {
                text-align: right;
                margin: 5px 10px 20px auto;
                position: relative;
            }
            .e2c {
                margin: 5px auto 20px 10px;
                position: relative;
            }
            .c2e-content, .e2c-content {
                display: inline-block;
                font-size: 20px;
                font-family: KaiTi;
                width: 300px;
                height: 65px;
                background-color: #9EEA6A;
                position: absolute;
                top: 5px;
                right: 90px;
                text-align: left;
                padding: 5px;
                border-radius: 10px;
                word-break: break-all;
            }
            .e2c-content {
                background-color: white;
                top: 5px;
                left: 90px;
            }
            .c2e-time, .e2c-time {
                font-size: 15px;
                position: relative;
                left: 180px;
                height: 0px;
                width: 150px;
            }
            .c2e-time {
                left: 550px;
            }

            /*消息输入框 */
            textarea {
                width: 895px;
                height: 100px;
                font-size: 20px;
                font-family: KaiTi;
            }
            #input-text {
                width: 900px;
                border-style: solid;
                border-width: thick;
                border-color: gray;
                text-align: center;
            }
            input[type='submit'] {
                font-family: KaiTi;
                font-size: 25px;
                width: 150px;
                height: 50px;
            }
            input[type='submit'] {
                cursor: pointer;
            }
            /*提示 */
            #tips {
                text-align: right;
                font-family: KaiTi;
                height: 0;
            }
		</style>
	</head>

	<body>
		<?php 
            nav();			// 导航栏
            chat_frame();
		?>
	</body>
    <script>
        // 修改每个信息显示区的高度
        var all_content_divs = [...(document.getElementsByClassName('c2e-content')), 
        ...(document.getElementsByClassName('e2c-content'))];
        for (var i = 0; i < all_content_divs.length; i++) {
            var content = all_content_divs[i].innerHTML;
            // 根据行数确定高度（一行15个汉字，一行给25px高度）
            var height = Math.ceil(content.length / 15) * 25;
            // 小于等于75直接跳过
            if (height <= 75) {
                continue;
            }
            // 设置高度
            all_content_divs[i].style.height = height + "px";
            all_content_divs[i].parentNode.style.height = (height + 10) + "px";
        }

        // 将滚动条拉到最下面
        var ele = document.getElementById('display-contents');
        ele.scrollTop = ele.scrollHeight;
    </script> 
</html>