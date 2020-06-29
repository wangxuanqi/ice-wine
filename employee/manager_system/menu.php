<?php
// 导航栏
function nav() {
	// 每个菜单项的名字
	$menuItem_names = Array("员工", "订单", "库存", "客户", "日志", "个人中心");
	// 每个菜单项点的链接页面
	$menuItem_links = Array("system.php?table=employee", "system.php?table=orders", "system.php?table=storehouse", "system.php?table=customer", "system.php?table=logs", "system.php?table=install");
	// 输出成html标签
	echo "<nav>";
	for ($i = 0; $i < count($menuItem_names); $i++) {
		$name = $menuItem_names[$i];
		$link = $menuItem_links[$i];
		echo "<a href='$link'><li id='menu-item-$i'>$name</li></a>";
	}
	echo "</nav>";
	if(is_array($_GET)&&count($_GET)>0)//先判断是否通过get传值了
    {
        if(isset($_GET["table"]))//是否存在"id"的参数
        {
            $table=$_GET["table"];//存在
			
        }
    }
	
}

// 导航栏的样式
function nav_css() {
	// 每个菜单项的图片
	$menuItem_icons = Array(
		"employee.png", "order.png", "stork.png",
		"customer.png", "logs.png", "install.png" );
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
	echo "
	body {
		margin: 0;
	}
	";
}

?>