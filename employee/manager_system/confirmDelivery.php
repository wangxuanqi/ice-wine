<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>发货</title>
</head>

<body>
<?php 
	include ("../conn.php");
    $key = $_GET["oid"];
    $e_id = $_COOKIE["e_id"];
	$updateSql = "UPDATE orders SET o_state = '待收货' where o_id = '$key'";
	$updateResult = mysqli_query($conn,$updateSql);
	if($updateResult){
		//插入logs表
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','customer','update','$key');";
		$result=$conn->query($sql);
		echo "<script language=javascript>window.alert('发货成功！');
        window.location.href = 'printData.php?table=orders';
			</script>";
	}else{
		echo "<script language=javascript>window.alert('发货失败！');
			
			</script>";
	}
	
?>
</body>
</html>
