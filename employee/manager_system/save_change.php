<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
	include ("../conn.php");
	$tableName=$_GET["table"];  
	$key=$_GET["key"];
	$e_id = $_COOKIE["e_id"];
	$sql="SHOW FULL COLUMNS FROM $tableName";
	$columeResult=mysqli_query($conn,$sql);
	$columeRow = array();
	$numOfColume = 0;                           //表格的字段数
	// 获取表的所有字段名

		
	while ($row = mysqli_fetch_row($columeResult)) {
		if($numOfColume==0)
			$keyColume = $row[0];
		$columeRow[$numOfColume] = $row[0];
		$numOfColume++;
	}
	$val = array();
	//获取传来所要增加的信息
	for($i=0; $i < $numOfColume; $i++){
		$val[$i] = $_POST[$columeRow[$i]];
	}
	$tmp = ''; 	//字段名的集合
	
	for($i=0; $i < $numOfColume; $i++){
		$tmp = $tmp."$columeRow[$i]='$val[$i]'";
		if($i!=$numOfColume-1){
			$tmp = $tmp.",";
		}
	}
	//echo "$tmp";
	$insertSql = "UPDATE $tableName SET $tmp WHERE $keyColume = '$key';";
	//$result = mysqli_query($conn, $sql) or die(mysql_error());  //如果添加成功,返回真给$result ,否则为false.
	$insertResult =	mysqli_query($conn,$insertSql);
	if($insertResult)
	{
		//插入logs表
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','$tableName','update','$key');";
		$result=$conn->query($sql);
		echo "<script language=javascript>window.alert('修改内容成功');
			window.location.href = 'printData.php?table=$tableName';
			</script>";

		
	}
	else
	{
		echo "<script language=javascript>window.alert('修改内容失败');
			
			</script>";

	}
?>
</body>
</html>