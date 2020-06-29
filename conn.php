<?php
// 连接到数据库
$hostname = "localhost";	// 主机名
$username = "root";			// 用户名
$password = "523813";		// 密码
$dbName = "sw_wine";			// 操作的数据库
// 建立连接
$conn = mysqli_connect($hostname, $username, $password);
// 设置编码集
$sql = "set names utf8";
mysqli_query($conn, $sql);
// 选择数据库
$db = mysqli_select_db($conn, $dbName);
?>