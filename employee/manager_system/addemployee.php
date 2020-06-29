<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>后台系统管理</title>
	<script>
	
		function returnLastPage(table){
			window.location.href = "printData.php?table=employee";
		}
	</script>
</head>
	<style>
	<?php
	include("menu.php");
	nav_css();
	
	?>
		.mainicon{
			background: url("./icons/main.png") no-repeat;
			background-size: 40px;
			padding: 5px 0 5px 50px;
			display: inline-block;
			margin: 20px 30px 20px 150px;
		}
		.righticon{
			background: url("./icons/arrow_forward.png") no-repeat;
			background-size: 40px;
			padding: 5px 0 5px 50px;
			display: inline-block;
			margin: 20px 30px 20px 0px;
		}
		.fontstyle{
			font-weight: 1000;
			font-size: 25px;
			font-family: serif;
			padding: 15px 0px 15px 0px;
			color: #2F8616;
		}
	</style>

<body>
	<?php
		include("../function.php");
		include("../style.php");
		include ("../conn.php");
		judge();
		nav();
		$table= "employee";
		$e_id = $_COOKIE["e_id"];
		$tip = "员工管理";
		$memuId = "menu-item-2";
		$tip1 = '查看员工表';
		$tip2 = '员工注册';
		
		$styleChange = "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			</script>";
		echo $styleChange;
		
		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<a href='printData.php?table=employee'><span class='righticon'><font class='fontstyle'>$tip1</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip2</font></span>";
	
		$sql2 = "SHOW FULL COLUMNS FROM $table"; //获取表格的所有字段名
		$columeResult2 = mysqli_query($conn,$sql2);
		$numOfColume = 0;
		$colume2 = array();
		echo 	"<table class='tableStyle1' >
					<tr>
						<td align='center' class='titleStyle'>请填写注册的员工信息</td>
					</tr>
				</table>
				<form action='save_insert.php?table=$table' method='post'>";
		while ($row = mysqli_fetch_row($columeResult2)) { //获取所有的字段名
			$colume2[$numOfColume] = $row[0];
			//echo "$colume[$numOfColume]";
			
				echo	"<table class='tableStyle2'>
						<tr>
							<div class = 'div2' >
								<td width='40%'  class='columeStyle' >$colume2[$numOfColume]</td>
								<td width='60%' ><input type='text' class='mytxt' name='$colume2[$numOfColume]'    size='25'/></td>
							</div>
						</tr>
					</table>";
				$numOfColume++;
			
			
		}
		echo			"<table class='tableStyle1'>
						<tr>
							<div class = 'div2' >
								<td align='center'><input type='submit' class='btns' name='submit1' value='确定添加'/></td>
							</div>
						</tr>
					</table>
				</form>";
		
		echo "<div >
		<input type='button' value='返回上一页'  class = 'returnbutton'  onclick = 'returnLastPage(\"$table\")' />
		</div>";
	?>
	
</body>
</html>