<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>解除拉黑</title>
</head>

<body>
<?php 
	include ("../conn.php");
    $key = $_GET["cid"];
    $e_id = $_COOKIE["e_id"];
	$updateSql = "UPDATE customer SET c_state = 'nor' where c_id = '$key'";
	$updateResult = mysqli_query($conn,$updateSql);
	if($updateResult){
		//插入logs表
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','customer','update','$key');";
		$result=$conn->query($sql);
		echo "<script language=javascript>window.alert('解除拉黑成功！');
        window.location.href = 'printData.php?table=customer';
			</script>";
	}else{
		echo "<script language=javascript>window.alert('解除拉黑失败！');
			
			</script>";
	}
	
?>
</body>
</html>
