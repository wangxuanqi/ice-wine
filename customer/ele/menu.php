<?php
// 导航栏
function nav() {
	// 每个菜单项的名字
	$menuItem_names = Array("浏览商品", "消息", "我的购物车", "个人中心", "帮助");
	// 每个菜单项点的链接页面
	$menuItem_links = Array(
		"brwose_products.php", "message.php", "purchase_car.php",
		"personal_center.php", "help.php");
	// 输出成html标签
	echo "<nav>";
	for ($i = 0; $i < count($menuItem_names); $i++) {
		$name = $menuItem_names[$i];
		$link = $menuItem_links[$i];
		echo "<a href='$link'><li id='menu-item-$i'>$name</li></a>";
	}
	echo "</nav>";
}

// 导航栏的样式
function nav_css() {
	// 每个菜单项的图片
	$menuItem_icons = Array(
		"brwose_products.png", "message.png", "purchase_car.png",
		"personal_center.png", "help.png");
	// 菜单项数目
	$menuItem_num = count($menuItem_icons);
	// 构建样式
	for ($i = 0; $i < $menuItem_num; $i++) {
		$icon = $menuItem_icons[$i];		// 图标
		// 正常情况样式
		echo 
		"#menu-item-$i {".
		"	background: url(./icons/$icon) no-repeat;".
		"	background-size: 40px;".
		"	padding: 5px 0 5px 50px;".
		"	display: inline-block;".
		"	margin: 0 30px 0 30px;".
		"}".
		// 悬浮时样式
		"#menu-item-$i:hover {".
		"	font-weight: bold;".
		"	color: #F4606C;".
		"	text-shadow: 0 0 2px;".
		"}";
	}
	echo 
	// 第一个菜单项样式左外边距重新调整
	"#menu-Item0 {".
	"	margin: 0 30px 0 0;".
	"}".
	// nav的样式
	"nav {".
	"	font-size: 25px;".
	"	text-align: center;".
	"	font-family: KaiTi;".
	"	background-color: #BEE7E9;".
	"	padding: 15px 0 15px 0;".
	"}";
	// 消去body的外边距
	echo "
	body {
		margin: 0;
		
	}";
}

?>