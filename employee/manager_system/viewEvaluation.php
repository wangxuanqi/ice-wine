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
			$tip2 = '员工员工评价';
			$colume = array("员工评价id","评价");
			$order = "select e_eva_id,e_evaluate FROM employee_evaluate Where e_id='$key'"; 
		}else if($table == "storehouse"){
			$tip = "商品管理";
			$memuId = "menu-item-2";
			$tip1 = '查看商品表';
			$tip2 = '查看冰酒商品评价';
			$colume = array("商品评价id","评价星级","评价");
			$order = "select g_eva_id,g_star,g_evaluate FROM goods_evaluate Where g_id='$key'"; 
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
		if($table == 'storehouse'){
			$sql = "select AVG(g_star) FROM goods_evaluate Where g_id='$key'";
			$result = mysqli_query($conn,$sql);
			if($result){
				if($row = mysqli_fetch_array($result)){
					echo "<p class='pp'>冰酒$key.平均评价星级为：$row[0]</p>";
				}
			}
		}
	
		echo "<table class='table4_5' border='1' bordercolor = '#000000' style = 'text-align: center;margin: 0 auto'>
			<caption class = 'tabletitle' style='font-size:40px;'>
				<strong>
					评价表
				</strong>
			</caption>
			<tr>";
		
		
	
	
	
		$numOfColume = count($colume);
		for($i = 0;$i < $numOfColume;$i++){
			echo "<th class = 'colume'>$colume[$i]</th>";
		}
		//echo $numOfColume;
		echo "</tr>";
		
		$result = mysqli_query($conn,$order);
		if($result){
			while($row = mysqli_fetch_array($result))    //转成数组，且返回第一条数据,当不是一个对象时候退出
			{
				echo "<tr>";
				for($i = 0;$i < $numOfColume;$i++){
					echo "<td class ='code'>".$row[$i]."</td>";
				}
				echo "</tr>";
			}
			
			echo "</table>";
		}else{
			echo "<script language=javascript>
				window.alert('展示表格失败！');
			</script>";
		}
		
		echo "<div >
		<input type='button' value='返回上一页'  class = 'returnbutton'  onclick = 'returnLastPage(\"$table\")' />
		</div>";
	?>
	
</body>
</html>