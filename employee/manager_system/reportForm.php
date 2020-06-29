<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>后台系统管理</title>
	<script>
		document.getElementById('$memuId').style.fontWeight='bold';
		document.getElementById('$memuId').style.color='#F4606C';
		document.getElementById('$memuId').style.textShadow='0px 0px 2px';
		function selectjt(){
			$(document).ready(function(){
   				$("#select_id").change(function(){
					var selected=$(this).children('option:selected').val()
					window.location.href = "reportForm.php?month="+selected;
				});
			});				   							   
		}
		function changeMonth(){
			var myselect = document.getElementById("select");
			var index = myselect.selectedIndex;
			window.location.href = "reportForm.php?month=2019-" + myselect.options[index].value;
		}
		function returnLastPage(){
			window.location.href = "system.php?table=orders";
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
		
		.form_select {
			 width: 240px;
   			height: 34px;
  		 	overflow: hidden;
   			font-size: 15px;
			margin: 20px 30px 20px 150px;
		}

	</style>

<body>
	<?php
		include("../function.php");
		include("../style.php");
		include("../conn.php");
		judge();
		nav();

		$tip = "订单管理";
		$memuId = "menu-item-1";
		$tip1 = '查看月季报表';
		$year = substr($_GET['month'], 0, 4);
		$month = substr($_GET["month"], 5);
		$e_id = $_COOKIE["e_id"];
		$styleChange = "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			</script>";
		echo $styleChange;
		
		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip1</font></span><br>";
		echo "
		<select class='form_select' id='select' onchange='changeMonth()'>
			<option value='$month' selected='selected'>$year-$month</option>";
		for($i = 1;$i <= 12;$i++){
			if ("".$i === $month) {
				continue;
			}
			echo "<option value='$i'>$year-$i</option>";
		}
		echo "</select>";
			

		
		echo "<table class='table4_5' border='1' bordercolor = '#000000' style = 'text-align: center;margin: 0 auto'>
			<caption class = 'tabletitle'>
				<strong>
					月季报表
				</strong>
			</caption>
			<tr>";
		
		$colume = array("年月","商品id","商品名称","销售数量","销售单价","销售总额");
		$numOfColume = count($colume);
		for($i = 0;$i < $numOfColume;$i++){
			echo "<th class = 'colume'>$colume[$i]</th>";
		}
		//echo $numOfColume;
		echo "</tr>";

		$order = "
		SELECT  date_format(ord.o_time,'%Y-%m'), ord.g_id, sto.g_name, sum(ord.buy_num), sto.g_price,sum(ord.total_price)
		FROM  
			orders ord,storehouse sto  
		WHERE
			ord.g_id = sto.g_id AND date_format(ord.o_time,'%Y-%m') = '$year-$month' AND ord.o_state!='已退款'
		GROUP BY
			ord.g_id
		;";         //获取表格的所有内容
		
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
		<input type='button' value='返回上一页'  class = 'returnbutton'  onclick = 'returnLastPage()' />
		</div>";
	?>
	
</body>
</html>