<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>后台系统管理</title>
	<script>
		function returnLastPage(table){
			if(table == "customer_logs" || table == "employee_logs")
				table = "logs";
			window.location.href = "system.php?table="+table;
		}
		function connectCustomer(customer){
			window.location.href = "connectCustomer.php?cid="+customer;
		}
		function addIceWine(){
			window.location.href = "addIceWine.php";
		}
		function addemployee(){
			window.location.href = "addemployee.php";
		}
		function del(table,key){
			var truthBeTold = window.confirm("您确定要删除该项目吗？");
			if (truthBeTold) {
				window.location.href = "deleteIn.php?table="+table+"&key="+key;
			} else
				window.alert("取消删除！"); 
		}
		function changeIn(table,key) {
			window.location.href = "changeIn.php?table="+table+"&key="+key;
        
		}
		function viewEvaluation(table,key){
			window.location.href = "viewEvaluation.php?table="+table+"&key="+key;
		}
		function  blockCustomer(customer){
			var truthBeTold = window.confirm("您确定要拉黑该顾客吗？");
			if (truthBeTold) {
				window.location.href = "blockCustomer.php?cid="+customer;
			} else
				window.alert("取消删除！"); 
		}
		function  cancelblockCustomer(customer){
			var truthBeTold = window.confirm("您确定要解除拉黑该顾客吗？");
			if (truthBeTold) {
				window.location.href = "cancelblockCustomer.php?cid="+customer;
			} else
				window.alert("取消解除拉黑！"); 
		}
		function  confirmDelivery(oid){
			var truthBeTold = window.confirm("您确认此订单要发货吗？");
			if (truthBeTold) {
				window.location.href = "confirmDelivery.php?oid="+oid;
			} else
				window.alert("取消发货！"); 

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
		$table=$_GET["table"];
		$e_id = $_COOKIE["e_id"];
		$tip = "主页";
		if($table == "employee"){
			$tip = "员工管理";
			$memuId = "menu-item-0";
			$tip1 = '查看员工表';
		}else if($table == "orders"){
			$tip = "订单管理";
			$memuId = "menu-item-1";
			$tip1 = '查看订单表';
		}else if($table == "storehouse"){
			$tip = "商品管理";
			$memuId = "menu-item-2";
			$tip1 = '查看商品表';
		}else if($table == "customer"){
			$tip = "客户管理";
			$memuId = "menu-item-3";
			$tip1 = '查看客户表';
		}else if($table == "employee_logs"){
			$tip = "日志管理";
			$memuId = "menu-item-4";
			$tip1 = '查看员工日志表';
		}else if($table == "customer_logs"){
			$tip = "日志管理";
			$memuId = "menu-item-4";
			$tip1 = '查看客户日志表';
		}
		$styleChange = "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			</script>";
		echo $styleChange;
		
		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip1</font></span>";
		
	
		
		echo "<table class='table4_5' border='1' bordercolor = '#000000' style = 'text-align: center;margin: 0 auto'>
			<caption class = 'tabletitle'>
				<strong>
					$table
				</strong>
			</caption>
			<tr>";
		if($table == "employee"){
			$colume = array("员工id","员工姓名","性别","职位","工资","联系方式","出生日期");
		}else if($table == "orders"){
			$colume = array("订单id","客户id","客户联系方式","收货地址","运费","商品id","商品数量","员工id","下单时间","订单状态","总额","税率");
		}else if($table == "storehouse"){
			$colume = array("商品id","名称","单价","成本","生产日期","保质期","库存","缺货提醒阈值","规格");
		}else if($table == "customer"){
			$colume = array("客户id","用户名","性别","密码","联系方式","积分","余额","常用地址","等级","状态");
		}else if($table == "employee_logs"){
			$colume = array("员工日志id","员工id","时间","表名","操作","键值");
		}else if($table == "customer_logs"){
			$colume = array("客户日志id","客户id","时间","表名","操作","键值");
		}
		$numOfColume = count($colume);
		for($i = 0;$i < $numOfColume;$i++){
			echo "<th class = 'colume'>$colume[$i]</th>";
		}
		if($table == "customer"  || $table == "employee" || $table == "storehouse" || $table == "orders"){
			echo "<th class = 'colume'>操作</th>";
		}
		//echo $numOfColume;
		echo "</tr>";

		$order = "select * FROM $table";         //获取表格的所有内容
		$result = mysqli_query($conn,$order);
		if($result){
			while($row = mysqli_fetch_array($result))    //转成数组，且返回第一条数据,当不是一个对象时候退出
			{
				echo "<tr>";
				for($i = 0;$i < $numOfColume;$i++){
					echo "<td class ='code'>".$row[$i]."</td>";
				}
				if($table == "customer"){
					echo "<td><input type='button' value='联系' name='button1' class = 'buttonstyle' onclick = ' connectCustomer(\"$row[0]\")'/>&nbsp&nbsp";
					if($row[9] == "nor")
						echo "<input type='button' value='拉黑' name='button1' class = 'buttonstyle' onclick = ' blockCustomer(\"$row[0]\")'/>&nbsp&nbsp</td>";
					else if($row[9] == "blocked")
						echo "<input type='button' value='解除拉黑' name='button1' class = 'buttonstyle' onclick = ' cancelblockCustomer(\"$row[0]\")'/>&nbsp&nbsp</td>";
				}
				if($table == "employee"|| $table == 'storehouse'){
					echo "<td><input type='button' value='修改' name='button1' class = 'buttonstyle' onclick = ' changeIn(\"$table\",\"$row[0]\")'/>&nbsp&nbsp";
					echo "<input type='button' value='删除' name='button1' class = 'buttonstyle' onclick = ' del(\"$table\",\"$row[0]\")'/>&nbsp&nbsp";
						echo "<input type='button' value='查看评价' name='button1' class = 'buttonstyle' onclick = ' viewEvaluation(\"$table\",\"$row[0]\")'/>&nbsp&nbsp</td>";
				}
				if($table == "orders"){
					if($row[9] == "待发货")
						echo "<td><input type='button' value='确认发货' name='button1' class = 'buttonstyle' onclick = ' confirmDelivery(\"$row[0]\")'/>&nbsp&nbsp</td>";
				}
				echo "</tr>";
			}
			
			echo "</table>";
		}else{
			echo "<script language=javascript>
				window.alert('展示表格失败！');
			</script>";
		}
		if($table == 'storehouse'){
			 echo "<div >
			<input type='button' value='增加冰酒商品'  class = 'showbutton'  onclick = 'addIceWine()' />
			</div>";
		}
		if($table == 'employee' ){
			 echo "<div >
			<input type='button' value='员工注册'  class = 'showbutton'  onclick = 'addemployee()' />
			</div>";
		}
		echo "<div >
		<input type='button' value='返回上一页'  class = 'returnbutton'  onclick = 'returnLastPage(\"$table\")' />
		</div>";
	?>
	
</body>
</html>