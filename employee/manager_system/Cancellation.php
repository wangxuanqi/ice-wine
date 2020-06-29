<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
	setcookie("e_id");
	setcookie("e_pwd");
	echo "<script language=javascript>window.alert('退出登陆成功！');
			window.location.href = '../../login_register/login_register.php';
			</script>";
?>
</body>
</html>