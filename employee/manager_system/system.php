<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>后台系统管理</title>
		<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			function showtable(table){
				window.location.href = "printData.php?table="+table;
			}
			function showMonthReport(){
				window.location.href = "reportForm.php?month=2019-12";
			}
			function connectCustomer(){
				window.location.href = "message.php?state=未读";
			}
			function shortageWarn(){
				window.location.href = "shortageWarn.php";
			}
			function Cancellation(){
				var truthBeTold = window.confirm("您确定要退出登陆吗？");
				if (truthBeTold) {
					window.location.href = "Cancellation.php";
				} else
					window.alert("取消退出！"); 
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
			height: 20;
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
			include("../conn.php");
			judge();
			nav();
			$table=$_GET["table"];
			$e_id = $_COOKIE["e_id"];
			$tip = "主页";
			if($table == "employee"){
				$tip = "员工管理";
				$memuId = "menu-item-0";
				$buttonValue = '查看员工表';
			}else if($table == "orders"){
				$tip = "订单管理";
				$memuId = "menu-item-1";
				$buttonValue = '查看订单表';
			}else if($table == "storehouse"){
				$tip = "商品管理";
				$memuId = "menu-item-2";
				$buttonValue = '查看商品表';
			}else if($table == "customer"){
				$tip = "客户管理";
				$memuId = "menu-item-3";
				$buttonValue = '查看客户表';
			}else if($table == "logs"){
				$tip = "日志管理";
				$memuId = "menu-item-4";
				$buttonValue = '日志表';	
			}else if($table == "install"){
				$tip = "个人中心";
				$memuId = "menu-item-5";
				$buttonValue = '注销';	
			}
			$styleChange = "<script>
				document.getElementById('$memuId').style.fontWeight='bold';
				document.getElementById('$memuId').style.color='#F4606C';
				document.getElementById('$memuId').style.textShadow='0px 0px 2px';
				</script>";
			echo $styleChange;
			
			echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
			//echo "<span class='righticon'><font class='fontstyle'>$tip</font></span>";
			if($table!="logs" && $table!="install")
				echo "<div class='div1' >
				<input type='button' value='$buttonValue'  class='showbutton'  onclick = 'showtable(\"$table\")'/>
				</div>";
			if($table == "orders"){
				echo "<div class='div1' >
					<input type='button' value='查看月季报表'  class='showbutton'  onclick = 'showMonthReport()'/>
					</div>";
			}else if($table == 'storehouse'){
				echo "<div class='div1' >
					<input type='button' value='缺货提醒'  class='showbutton'  onclick = 'shortageWarn()'/>
					</div>";
			}else if($table == 'customer'){
				echo "<div class='div1' >
				<input type='button' value='查看客户消息'  class='showbutton'  onclick = 'connectCustomer()'/>
				</div>";
			}else if($table == 'logs'){
				$table1 = "employee_logs";
				$table2 = "customer_logs";
				
				echo "<div class='div1' >
				<input type='button' value='查看员工日志表'  class='showbutton' style = 'width:15%;' onclick = 'showtable(\"$table1\")'/>
				</div>";
				echo "<div class='div1' >
				<input type='button' value='查看客户日志表'  class='showbutton' style = 'width:15%;' onclick = 'showtable(\"$table2\")'/>
				</div>";
			}else if($table == 'install'){
				$order = "select e_name,e_sex FROM employee WHERE e_id='$e_id'";         //获取表格的所有内容
				$result = mysqli_query($conn,$order);
				if($result){
					while($row = mysqli_fetch_array($result)){
						$name = $row[0];
						$sex = $row[1];
					}
				}
				echo "<p class='pp'>用户名:$name</p><p class='pp'>性别:$sex</p>";
				echo "<div class='div1' >
				<input type='button' value='退出登陆'  class='showbutton' style='margin-left: 48%;;' onclick = 'Cancellation ()'/>
				</div>";
			}
			
			
		?>
		
	</body>
</html>