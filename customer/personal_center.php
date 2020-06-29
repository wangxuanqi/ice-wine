<!--个人中心-->
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

// 开启会话，用于传数据
session_start();



// 这个页面的所有小菜单项
// 每个菜单项的名字
$opMenuItem_names = Array(
	"充值", "待发货", "待收货", 
	"待评价", "历史订单",  "编辑资料", 
	"注销");
// 每个菜单项对应的关键字
$opMenuItem_keys = Array(
	"top_up", "back_orders", "received", 
	"evaluation", "order_history", "edit_data", 
	"logout");
// 菜单项的数目
$opMenuItem_num = count($opMenuItem_names);

// 把页面的构成部分加载进来
// 加载菜单栏
include("./ele/menu.php");    			
// 加载小功能
for ($i = 0; $i < $opMenuItem_num; $i++) {
	include("$root_dir/customer/ele/".$opMenuItem_keys[$i].".php");
}
// 变成vip的小功能也加载进来
include("$root_dir/customer/ele/become_vip.php");


// 个人信息
function per_inf() {
	$picture_path = "./head-portrait/hui.jpg";		// 头像图片路径
	
	// 获取顾客所有信息
	global $a_cus;
	global $c_id;					// id
	$c_name = $a_cus['c_name'];		// 用户名
	$c_money = $a_cus['c_money'];	// 余额
	$c_score = $a_cus['c_score'];	// 积分
	// 判断


	$level = $a_cus['level'];		// 是否是会员

	echo 
	"<div id='per-inf'>".
		// 头像
		"<img src='$picture_path' width='120px' height='120px' id='head-portrait'>".
		// 余额、积分和VIP
		"<div id='c_money-c_score-vip-inf'>".
			"余额：¥$c_money<br>积分：$c_score<br>会员：";
	// 判断是否是会员
	if ($level == 'vip') {
		echo "<div id='vipImg'></div>";
	} else {
		echo "非会员&emsp;<a href='javascript:void(0)' id='become-vip' onclick='open_become_vip()'>成为会员</a>";
	}	
	echo 
		"</div>".
	"</div>";
}

// 个人信息样式
function per_inf_css() {
	echo
	"#head-portrait {".
		"border-radius: 20%;".
		"overflow: hidden;".
		"display: inline-block;".
	"}".
	
	// 余额和积分样式
	"#c_money-c_score-vip-inf {".
		"display: inline-block;".
		"position: absolute;".
		"top: -5px;".
		"height: 120px;".
		"padding: 5px 20px;".
		"line-height: 40px;".
		"font-size: 25px;".
		"font-family: KaiTi;".
		"text-align: left;".
	"}".
	// 个人信息样式
	"#per-inf {".
		"text-align: center;".
		"margin-top: 80px;".
		"position: relative;".
	"}";

	echo 
	"#vipImg {".
		"display: inline-block;".
		"background: url(./icons/vip.png) no-repeat;".
		"background-size: 20px 20px;".
		"width: 20px;".
		"height: 20px;".
	"}";
}

// 个人中心的操作菜单
function op_memu() {
	global $opMenuItem_names;		// 每个菜单项的名字
	global $opMenuItem_keys;		// 每个菜单项的关键字
	global $opMenuItem_num;			// 菜单项数目
	$func_names = $opMenuItem_keys;	// 点击时调用的js函数名

	// 输出成html标签（用表格输出，每行4列）
	echo "<table align='center'><tbody>";
	for ($i = 0; $i < $opMenuItem_num; $i++) {
		// tr开始标签
		if ($i % 4 == 0) {
			echo "<tr>";
		}
		// 输出成单元格
		$name = $opMenuItem_names[$i];
		$func_name = $func_names[$i];
		// 注销的点击事件区别对待
		if ($func_name === 'logout') {
			echo "<td><a href='../login_register/login_register.php' class='op-link'><div id='op-memu-item$i'></div>$name</a></td>";
		} else {
			echo "<td><a href='javascript:void(0)' class='op-link' onclick='open_$func_name()'><div id='op-memu-item$i'></div>$name</a></td>";
		}
		// tr结束标签
		if ($i % 4 == 3) {
			echo "</tr>";
		}
	}
	if ($opMenuItem_num % 4 != 0) {
		// 最后一个结束符
		echo "</tr>";
	}
	echo "</tbody></table>";
}

// 个人中心的操作菜单对应的样式
function op_menu_css() {
	global $opMenuItem_keys;	// 菜单项的关键字
	global $opMenuItem_num;		// 菜单项数目
	
	// 构建样式
	for ($i = 0; $i < $opMenuItem_num; $i++) {
		$icon = $opMenuItem_keys[$i].".png";	// 图标
		// 用div加入图标
		echo 
		"#op-memu-item$i {".
		"	background: url(./icons/$icon) no-repeat;".
		"	background-position: center;".
		"	background-size: 60px;".
		"	padding: 40px 50px 40px 50px;".
		"}";
	}
	// 其他样式
	echo
	"td {".
	"	text-align: center;".
	"	padding: 20px 50px;".
	"}".
	".op-link {".
	"	display: block;".
	"	text-decoration: none;".
	"	font-family: KaiTi;".
	"	font-size: 20px;".
	"}".
	// a标签悬浮
	".op-link:hover {".
		"	font-weight: bold;".
		"	color: #F4606C;".
		"	text-shadow: 0 0 2px;".
	"}"."
	table {
		margin-top: 50px;
	}
	"
	;
}

// 判断操作结果
function op_res() {
	// 充值成功
	if (isset($_SESSION['top_up_res']) && $_SESSION['top_up_res'] == 'true') {
		echo "<script> alert('充值成功(*^▽^*)！'); </script>";
		// 清除结果
		unset($_SESSION["top_up_res"]);
	}
	// 修改成功
	else if (isset($_SESSION['edit_data_res']) && $_SESSION['edit_data_res'] == 'true') {
		echo "<script> alert('修改成功(*^▽^*)！'); </script>";
		// 清除结果
		unset($_SESSION["edit_data_res"]);
	}
	// 评论成功
	else if (isset($_SESSION['evaluate_res']) && $_SESSION['evaluate_res'] == 'true') {
		echo "<script> alert('评论成功(*^▽^*)！'); </script>";
		// 清除结果
		unset($_SESSION["evaluate_res"]);
	}
	// 删除订单
	else if (isset($_SESSION['delete_order_res']) && $_SESSION['delete_order_res'] == 'true') {
		echo "<script> alert('删除成功！'); </script>";
		// 清除结果
		unset($_SESSION["delete_order_res"]);
	}
	// 确认收货
	else if (isset($_SESSION['confirm_receipt_res']) && $_SESSION['confirm_receipt_res'] == 'true') {
		echo "<script> alert('确认成功，去写一下评论吧(*^▽^*)！'); </script>";
		// 清除结果
		unset($_SESSION["confirm_receipt_res"]);
	}
	// 退款
	else if (isset($_SESSION['refund_res']) && $_SESSION['refund_res'] == 'true') {
		echo "<script> alert('成功退款，钱已经返还到您的余额中了哦(#^.^#)！'); </script>";
		// 清除结果
		unset($_SESSION["refund_res"]);
	}
	// 变成vip的三种结果
	else if (isset($_SESSION['become_vip'])) {
		echo "<script> alert('".$_SESSION["become_vip"]."'); </script>";
		// 清除结果
		unset($_SESSION["become_vip"]);
	}
}



?>

<script>
	// 弹出指定窗体
	function open(id) {
		// 弹出div遮住背景
		document.getElementById('body-shade').style.display = 'block';
		// 弹出指定窗体
		document.getElementById(id).style.display = 'block';
	}
	// 关闭指定窗体（使用数组下标）
	function close(id) {
		// 拿走遮罩
		document.getElementById('body-shade').style.display = 'none';
		// 关闭指定窗体
		document.getElementById(id).style.display = 'none';
	}

	<?php 
		// 函数名
		$func_names = $opMenuItem_keys;
		array_push($func_names, "become_vip");
		// 产生函数
		for ($i = 0; $i < count($func_names); $i++) {
			$func_name = $func_names[$i];

			echo "
				function open_$func_name() {
					open('$func_name');
				}

				function close_$func_name() {
					close('$func_name');
				}
			";
		}
	?>

	// 评价遮罩
	function open_evaluation_shade(id) {
		// 开启遮罩
		document.getElementById('evaluation-shade').style.display = 'block';
		// 弹出评论框
		document.getElementById('evaluation_form_div').style.display = 'block';
		// 设置传输值
		document.getElementById('transfer_o_id').value=id;
	}
	function close_evaluation_shade() {
		// 关闭遮罩
		document.getElementById('evaluation-shade').style.display = 'none';
		// 关闭评论框
		document.getElementById('evaluation_form_div').style.display = 'none';
	}
</script>

<!DOCTYPE html>  
<html>  
	<head>  
		<meta charset="UTF-8">  
		<title>个人中心</title>  
		<style>
			<?php 
				nav_css(); 			// 导航栏样式
				per_inf_css();		// 顾客操作样式
				op_menu_css();		// 操作菜单样式
				// 以下全是小功能的样式
				become_vip_css();		// 变成vip
				edit_data_css();		// 编辑资料
				top_up_css();			// 充值
				back_orders_css();		// 待发货
				received_css();			// 待收货
				evaluation_css();		// 待评价
				order_history_css();	// 历史订单
			?>
			#body-shade {
      			display: none;
      			position: absolute;
      			top: 0%;
      			left: 0%;
      			width: 100%;
      			height: 100%;
      			background-color: black;
      			z-index:1001;
				-moz-opacity: 0.8;
				opacity:.50;
			}
			/*个人中心字体发亮*/
			#menu-item-3 {
				font-weight: bold;
				color: #F4606C;
				text-shadow: 0 0 2px;
			}
			.kaiti25 {
				font-family: KaiTi;
        		font-size: 25px;
			}
			#become-vip {
				font-size: 20px;
			}
			/*评价遮罩 */
			#evaluation-shade {
				/*位置控制*/
				width: 1100px;
				height: 500px;
				position: absolute;
				top: 50%;
				left: 50%;
				margin-left: -550px;
				margin-top: -250px;
				/*其他控制*/
				display: none;   /*一开始是隐藏状态*/
				z-index:1002;
				overflow: auto;
				padding: 20px;
				background-color: black;
      			z-index: 1003;
				-moz-opacity: 0.8;
				opacity:.50;
				border-radius: 2% 0 0 2%;
			}
		</style>
	</head>

	<body>
		<div id='body-shade'></div>
		<?php 
			// 判断操作结果
			op_res();

			// 小功能（初始时被隐藏）
			become_vip();		// 充值成为vip
			edit_data();		// 编辑资料
			top_up();			// 充值
			back_orders();		// 待发货
			received();			// 待收货
			evaluation();		// 待评价
			order_history();	// 历史订单
			

			nav();			// 导航栏
			per_inf();		// 个人信息
			op_memu();		// 顾客操作
		?>
		<div id='evaluation-shade'></div>
	</body> 
</html>
