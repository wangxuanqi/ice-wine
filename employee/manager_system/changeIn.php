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
		.pp{
			width: 100%;
			height: 45px;
			font-family:  serif;
			font-size: 30px;
			color:dodgerblue;
			
			display: block;
			line-height: 45px;
			text-align: center;
		}
	</style>

<body>
	<?php
		include("../function.php");
		include("../style.php");
		include ("../conn.php");
		judge();
		nav();
		$table= $_GET["table"];
		$key = $_GET["key"];
		$e_id = $_COOKIE["e_id"];
		if($table == "employee"){
			$tip = "员工管理";
			$memuId = "menu-item-0";
			$tip1 = '查看员工表';
			$tip2 = '员工信息修改';
		}else if($table == "storehouse"){
			$tip = "商品管理";
			$memuId = "menu-item-2";
			$tip1 = '查看商品表';
			$tip2 = '冰酒信息修改';
		}
		
		$styleChange = "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			</script>";
		echo $styleChange;
		
		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<a href='printData.php?table=employee'><span class='righticon'><font class='fontstyle'>$tip1</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip2</font></span>";
	
		$sql = "SHOW FULL COLUMNS FROM $table"; //获取表格的所有字段名
		$columeResult = mysqli_query($conn,$sql);
		$numOfColume = 0;
		$colume = array();
		while($row = mysqli_fetch_row($columeResult)){
			if($numOfColume == 0){
				$columename = $row[0];
			}
			$colume[$numOfColume] = $row[0];
			$numOfColume++;
		}
		//获取所要修改的那一行信息
		$selectSql = "select * from $table where $columename = '$key'";
		$res = mysqli_query($conn,$selectSql);
		$dbrow = mysqli_fetch_array($res,MYSQLI_ASSOC);
		echo "<form action='save_change.php?table=$table&key=$key' method='post'>";
		for($i = 0;$i < $numOfColume;$i++){
			$value =  $dbrow["$colume[$i]"];
			//将原本的信息设置在框内
			if($i == 0){
				if($table == 'employee'){
					$title = "请修改员工".$value."的信息";
					echo "<p class='pp'><strong>$title</strong></p>";
				}
					
				else if($table == 'storehouse'){
					$title = "请修改冰酒".$value."的信息";
					echo "<p class='pp'><strong>$title</strong></p>";
				}
					
			}
				echo	"<table class='tableStyle2'>
						<tr>
							<div class = 'div2' >
								<td width='40%'  class='columeStyle' >$colume[$i]</td>
								<td width='60%' align='left'><input type='text'  class='mytxt' name='$colume[$i]' size='25' 
								value = '$value'/></td>
							</div>
						</tr>
					</table>";
		}
		echo		"<table class='tableStyle1'>
						<tr>
							<div class = 'div2' >
								<td align='center'><input type='submit' class='btns' name='submit1' value='确定修改'/></td>
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