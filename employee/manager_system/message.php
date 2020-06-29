<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>后台系统管理</title>
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
	<script>
		function changestate(){
			var myselect = document.getElementById("select");
			var index = myselect.selectedIndex;
			window.location.href = "message.php?state=" + myselect.options[index].value;
		}
		function reply(customer){
			window.location.href = "reply.php?cid="+customer;
		}
		function changeState(conn_id){
			window.location.href = "changeState.php?conn_id="+conn_id;
		}
		function returnLastPage(){
			window.location.href = "system.php?table=customer";
		}
	</script>
<body>
	<?php
		include("../function.php");
		include("../style.php");
		include ("../conn.php");
		judge();
		nav();

			$tip = "客户管理";
			$memuId = "menu-item-3";
			$tip1 = '查看客户消息';
		$state=$_GET["state"];
		$styleChange = "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			</script>";
		echo $styleChange;
		
		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip1</font></span><Br>";
		echo "<select class='form_select' id='select' onchange='changestate()'>";
		echo "<option value='0' selected='selected'>$state</option>";
		$states = Array('未读', '已读', '已发送');
		for ($i = 0; $i < count($states); $i++) {
			$each_state = $states[$i];
			if ($each_state === $state) {
				continue;
			}
			echo "<option value='$each_state'>$each_state</option>";
		}
		echo "</select>";

		
		echo "<table class='table4_5' border='1' bordercolor = '#000000' style = 'text-align: center;margin: 0 auto'>
			<caption class = 'tabletitle'>
				<strong>
					消息
				</strong>
			</caption>
			<tr>";
		if($state == "未读"){
			$colume = array("消息编号","客户id","消息","发送时间");
			$order = "
		SELECT conn_id,c_id,message,conn_time
		FROM  
			connectM 
		WHERE
			read_state = 'unread' AND sender = 'customer'
		GROUP BY
			conn_id;";   
		}
		else if($state == "已读"){
			$colume = array("消息编号","客户id","员工id","消息","发送者","发送时间");
			$order = "
		SELECT conn_id,c_id,e_id,message,sender,conn_time
		FROM  
			connectM 
		WHERE
			read_state = 'read'
		GROUP BY
			conn_id;"; 
		}else if($state == "已发送"){
			$colume = array("消息编号","客户id","消息","发送者","发送时间");
			$order = "
			SELECT conn_id,c_id,message,sender,conn_time
			FROM  
				connectM 
			WHERE
				 sender = 'employee'
			GROUP BY
				conn_id;"; 
		}
			
		$numOfColume = count($colume);
		for($i = 0;$i < $numOfColume;$i++){
			echo "<th class = 'colume'>$colume[$i]</th>";
		}
		echo "<th class = 'colume'>操作</th>";
		//echo $numOfColume;
		echo "</tr>";

		      
		$result = mysqli_query($conn,$order);
		if($result){
			while($row = mysqli_fetch_array($result))    //转成数组，且返回第一条数据,当不是一个对象时候
			{
				echo "<tr>";
				for($i = 0;$i < $numOfColume;$i++){
					echo "<td class ='code'>".$row[$i]."</td>";
				}
				echo "<td><input type='button' value='回复' name='button1' class = 'buttonstyle' onclick = 'reply(\"$row[1]\")'/>&nbsp&nbsp";
				if($state == "未读"){
					echo "<input type='button' value='确认已读' name='button1' class = 'buttonstyle' onclick = 'changeState(\"$row[0]\")'/></td>";
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