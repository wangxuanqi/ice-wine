<!DOCTYPE html>


<html>  
	<head>  
		<meta charset="UTF-8">  
		<title>登录</title>  
		<style>
			body {
				background-image: url(background.jpg);
    			background-size: 100% 100%;
    			background-attachment: fixed;
			}
			h1 {
				color: white;
				text-align: center;
				margin-top: 100px;
				font-family: STKaiti;
				font-size: 70px;
				text-shadow: 0 0 10px;
			}
			input {
				width: 278px;
				height: 30px;
				margin-bottom: 30px;
				padding: 10px;
				font-size: 20px;
				border: 1px dashed;
				border-radius: 10px;
				font-family: STKaiti;
			}
			form {
				position: absolute;
				top: 60%;
				left: 80%;
				margin: -150px 0 0 -150px;
				width: 300px;
				height: 300px;
			}
			input[type='submit'] {
				width: 100px;
				height: 55px;
				border: none;
				margin: auto 23px;
				font-size: 25px;
				background-color: rgba(255, 255, 255, 0.5);
				color: white;
			}
			input[type='submit']:hover {
				cursor: pointer;
                font-weight: bold;
				text-shadow: 0 0 10px;
				font-size: 26px;
				font-weight: bold;
			}
		</style>
	</head>

	<body>
		<!--添加遮罩-->
		<div id='shadeDiv'></div>
		<!--标题-->
		<h1>欢迎来到“123木头人酒铺”</h1>
		<!--登录表单填写-->
		<form action="../server/server.php?op=1" method="post">
			<input type="tel" required="required" placeholder="账号" name="id">
			<input type="password" required="required" placeholder="密码" name="pwd">
			<input type="submit" value="登录" name="whatButton">
			<a><input type="submit" value="注册" name="whatButton"></a>
		</form>
		<?php
			// 开启会话接收数据
			session_start();
			// 判断是否有登录结果
			if (isset($_SESSION["login_res"]) && $_SESSION["login_res"] == 'false') {
				echo "<script> alert('账号或密码错误！请重新输入！'); </script>";
				// 清除这个结果
				unset($_SESSION["login_res"]);
			}
			// 判断是否有注册结果
			if (isset($_SESSION["register_res"])) {
				if ($_SESSION["register_res"] == 'false') {
					echo "<script> alert('注册失败！该账号已存在或不符合规范，请重试！'); </script>";
				} else if ($_SESSION["register_res"] == 'true') {
					echo "<script> alert('注册成功！快登录试试看吧(*^▽^*)！'); </script>";
				}
				// 清除这个结果
				unset($_SESSION["register_res"]);
			}
		?>
	</body> 
</html>