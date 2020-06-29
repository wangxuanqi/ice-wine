<!doctype html>
<?php
	setcookie("e_id","e000");
	setcookie("e_psw","123456");
?>
<html>
<head>
<meta charset="utf-8">
<title>后台系统管理</title>
	<script>
		function addNumber(key){
			document.getElementById('zhezhao').style.display='none';
			var number = document.getElementById("number").value;
			window.location.href = "addNumber.php?key="+key+"&number="+number;
		}
		function dianwo(){
			document.getElementById('zhezhao').style.display='';
		}
		function hidder(){
			document.getElementById('zhezhao').style.display='none';
				
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
		div{
			margin: auto;
			font-family:kameron;
			font-size: 50px;
			color:dodgerblue;
			width:600px;
			margin: 0 auto;
			text-align: center;
		}
		.div1{
			color:black;
			font-size: 30px;
			position: relative;
			top:30px;
			left:30px;
		}
		.div3{
			width: 300px;
			color:black;
			font-size: 40px;
		}
		body{
				margin: 0px;
			}
			.zhezhao{
				position: fixed;
				left: 0px;
				top: 0px;
				background: rgba(0,0,0,0.5);
				width: 100%;
				height: 100%;
				
			}
			.tankuang{
				position: relative;
				background-color: #fff;
				top:150px;
				width: 40%;
				height: 30%;
				border-radius: 10px;
				margin: 5% auto;
			}
			#header{
				height: 40px;
			}
			#header-right{
				position: absolute;
				width: 25px;
				height: 25px;
				border-radius: 5px;
				background: red;
				color:black;
				right: 0px;
				top: 0px;
				text-align: center;
			}
	</style>

<body>
	<?php
		include ("../conn.php");
		include("../function.php");
		include("../style.php");
		judge();
		nav();
		$user = $_COOKIE["e_id"];
		$tip = "商品管理";
		$memuId = "menu-item-2";
		$tip1 = '缺货提醒';
		$styleChange = "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';
			</script>";
		echo $styleChange;
		
		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip1</font></span>";
	
		echo "<div >
			
				<strong>
					缺货提醒
				</strong>

			</div>
			";
		$order = "select g_id,g_name,g_number,g_threshold FROM storehouse";
		$flag = "false";
		$result = mysqli_query($conn,$order);
		if($result){
			while($row = mysqli_fetch_array($result))    //转成数组，且返回第一条数据,当不是一个对象时候退出
			{
				$id = $row[0];
				$name = $row[1];
				$number = $row[2];
				$threshold = $row[3];
				if($number < $threshold){
					$sentence = $name."(".$id.")现存货物量为".$number.",少于阈值".$threshold."需要进货！";
					echo "<p class='pp'>$sentence&nbsp&nbsp<input type='button' value='进货' name='button1' class = 'buttonstyle' style='height:50px;width:90px;font-size:25px;' onclick = ' dianwo()'/><p>";
					$flag = "true";
					echo "		<div class='zhezhao' id='zhezhao'>
						<div class='tankuang'>
							<div id='header' class='div3'>
								<span>输入进货数量:</span>
								<input type='button' value='X' name='button1' class = 'buttonstyle' style='position: absolute;
				width: 25px;height: 25px;border-radius: 5px;right: 5px;top: 5px;font-size:25px;' onclick = 'hidder()'/>
								
							</div>
							<input type='text' class='mytxt' name='number' id='number' style='width: 200px;height: 30px;margin-top:30px;'   size='30'/>
							<input type='button' value='确认' name='button1' class = 'buttonstyle' style='position: absolute;
				width: 100px;height: 50px;border-radius: 5px;right: 20px;top: 150px;font-size:25px;' onclick = 'addNumber(\"$id\")'/>
						</div>
					</div>";
					echo "
					<script type='text/javascript'>
						document.getElementById('zhezhao').style.display='none';
					</script>";

				}
			}
		}else{
			echo "<script language=javascript>
				window.alert('展示失败！');
			</script>";
		}
		if($flag == "false"){
			echo "<div class = 'div1'>
				<strong>
				货物充足，暂时无需补充！</strong>
			</div>";
		}
	?>
	
</body>
</html>