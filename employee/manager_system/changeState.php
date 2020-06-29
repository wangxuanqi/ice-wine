<meta charset="utf-8">
<?php
	include("../function.php");
	include("../conn.php");
	$conn_id = $_GET["conn_id"];
	$e_id = $_COOKIE["e_id"];
	$db = new database();
	$result = $db->update("connectM","e_id='$e_id',read_state='read'","conn_id=$conn_id");
	if($result){
				//插入logs表
		date_default_timezone_set("Asia/Shanghai");
		$tmp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO employee_logs (e_id,time,table_name,operation,key_value) VALUES ('$e_id','$tmp','connectM','updata','$conn_id');";
		$result=$conn->query($sql);
		echo "<script language=javascript>
		window.location.href = 'message.php?eid=$e_id&state=未读';
		</script>";
	}else{
		echo "<script language=javascript>
		window.alert('确认消息失败！');
		</script>";
	}
?>