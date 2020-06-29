<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>后台系统管理</title>
	<script>
	</script>
</head>
	<style>
	<?php
	include("menu.php");
	nav_css();
	?>
		.mainicon{
			background: url("./icons/main.png") no-repeat;
			background-size: 40px;
			padding: 5px 0 5px 50px;
			display: inline-block;
			margin: 20px 30px 20px 150px;
		}
		.fontstyle{
			font-weight: 1000;
			font-size: 25px;
			font-family: serif;
			padding: 15px 0px 15px 0px;
			color: #2F8616;
		}
		div{
			margin: auto;
			font-family:kameron;
			font-size: 70px;
			color:mediumseagreen;
			width:600px;
			margin: 0 auto;
		}
		.div1{
			width:850px;
		}
	</style>

<body>
	<?php
		include("../function.php");
		$tip = "主页";
		nav();
		
		judge();
		$user = $_COOKIE["e_id"];
		echo "<span class='mainicon'><font class='fontstyle'>$tip</font></span>";
		echo "<div>尊敬的管理员$user</div>";
		echo "<div class='div1'>欢迎来到冰酒销售管理系统</div>";
		
		
	?>
	
</body>
</html>