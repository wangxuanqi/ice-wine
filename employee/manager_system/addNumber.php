<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
	include ("../conn.php");
	$number=$_GET["number"];  
	$key=$_GET["key"];
	$e_id = $_COOKIE["e_id"];
	$sql="UPDATE storehouse SET g_number=g_number+$number WHERE g_id='$key'";
	$result=mysqli_query($conn,$sql);
	echo $sql;
	if($result)
	{
		//插入logs表
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','$tableName','update','$key');";
		$result=$conn->query($sql);
		echo "<script language=javascript>
			window.location.href = 'shortageWarn.php';
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