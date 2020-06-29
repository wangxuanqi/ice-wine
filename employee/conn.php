<?php 
	$hostname = "localhost"; 	//主机名,可以用IP代替
	$database = "sw_wine"; 		//数据库名
	$username = "root"; 		//数据库用户名
	$password = "523813"; 		//数据库密码
	$conn = mysqli_connect($hostname, $username, $password, $database); 	
	//连接失败
	if(!$conn) {
		echo ('<h1>数据库连接失败</h1>');
	}
	// 设置编码集
	$sql = "set names utf8";
	mysqli_query($conn, $sql);
	mysqli_select_db($conn,$database); 
	$db = mysqli_select_db($conn,$database ) ;
?>