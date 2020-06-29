<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
<?php
	include ("../conn.php");
	//error_reporting(0); //由于一些问题，不加这个会出现一些警告
	$tableName=$_GET["table"];  
	$e_id = $_COOKIE["e_id"];
	//mysqli_query($conn, "set names utf8");
	$sql="SHOW FULL COLUMNS FROM $tableName";
	$columeResult=mysqli_query($conn,$sql);
	$columeRow = array();
	$numOfColume = 0;                           //表格的字段数
	// 获取表的所有字段名
	while ($row = mysqli_fetch_row($columeResult)) {
		$columeRow[$numOfColume] = $row[0];
		$numOfColume++;
	}
	$val = array();
	//获取传来所要增加的信息
	for($i=0; $i < $numOfColume; $i++){
		$val[$i] = $_POST[$columeRow[$i]];
	}
	$tmp_1 = ''; 	//字段名的集合
	$tmp_2 = '';	//所要增加的信息的集合
	
	for($i=0; $i < $numOfColume; $i++){
		$tmp_1 = $tmp_1."$columeRow[$i]";
		$tmp_2 = $tmp_2."'"."$val[$i]"."'";
		if($i!=$numOfColume-1){
			$tmp_1 = $tmp_1.",";
			$tmp_2 = $tmp_2.",";
		}
	}
	$insertSql = "INSERT INTO $tableName ($tmp_1) VALUES ($tmp_2);";
	$insertResult =	mysqli_query($conn,$insertSql);
	if($insertResult)
	{
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','$tableName','insert','$val[0]');";
		$result=$conn->query($sql);
		echo "<script language=javascript>
			window.location.href = 'printData.php?table=$tableName';
			</script>";
	}
	else
	{
		echo "<script language=javascript>window.alert('插入内容失败，可能是由于外键约束,请重新输入');
			</script>";

	}
?>
</body>
</html>