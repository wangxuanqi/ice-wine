<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>删除</title>
</head>

<body>
<?php 
	include ("../conn.php");
	$table = $_GET["table"];
	$key = $_GET["key"];
	$e_id = $_COOKIE["e_id"];
	//echo "$table";
	$sql1 = "SHOW FULL COLUMNS FROM $table"; //获取表格的所有字段名
	$columeResult1 = mysqli_query($conn,$sql1);
	if($row = mysqli_fetch_row($columeResult1))
		$columename = $row[0];
	$deleteSql = "delete from $table where $columename = '$key'";
	echo $deleteSql;
	//echo "$deleteSql";
	$deleteResult = mysqli_query($conn,$deleteSql);
	if($deleteResult){

		//插入logs表
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','$table','delete','$key');";
		$result=$conn->query($sql);
		echo "<script language=javascript>window.alert('删除成功！');
			window.location.href = 'printData.php?table=$table';
			</script>";
	}else{
		echo "<script language=javascript>window.alert('删除失败！');
			
			</script>";
	}
	
?>
</body>
</html>
