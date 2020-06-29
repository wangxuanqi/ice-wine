<meta charset="utf-8">
<?php
	include("../function.php");
	$text = $_POST["content"];
	$e_id = $_COOKIE["e_id"];
	$c_id = $_GET["c_id"];
	$flag = $_GET["flag"];
	$db = new database();
	echo $text;
	date_default_timezone_set("Asia/Shanghai");
	$time = date('Y-m-d H:i:s');
	$result = $db->insert("connectM","(c_id,e_id,sender,message,conn_time,read_state)","('$c_id','$e_id','employee','$text','$time','unread')");
	if($result){
		
		if($flag == "reply")
			echo "<script language=javascript>
			window.location.href = 'reply.php?cid=$c_id';
			</script>";
		else if($flag == "connect")
			echo "<script language=javascript>
			window.location.href = 'connectCustomer.php?cid=$c_id';
			</script>";
	}else{
		echo "<script language=javascript>
		window.alert('发送信息失败！');
		</script>";
	}
?>