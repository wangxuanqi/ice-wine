<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>后台系统管理</title>
<?php
	
	include ("../function.php");
	class Message{
		private $c_id;
		private $e_id;
		private $db ;
		public function  __construct($cid,$eid){
			
			$this->c_id = $cid;
			$this->e_id = $eid;
			$this->db = new database();
		}

		private function emp_inf() {
			$c_name = "客户$this->c_id";       // 名字
			$result = $this->db->select("c_connect","customer","c_id='$this->c_id'");
			if($result){
				if($row = mysqli_fetch_array($result)){
					$c_tel = $row[0];
				}
			}
			$img_path = "./images/touxiang1.jpg";   // 头像路径

			// 显示咨询员信息
			echo
			"<div id='emp'>".
				
				"<p id='emp-inf'>$c_name(联系电话：$c_tel)</p>".
			"</div>";
		}


		// 显示所有聊天记录
		private function all_contents() {
			// 两个人的头像路径
			$c_img_path = "./images/touxiang1.jpg";
			$e_img_path = "./images/kefu.jpg";
			$result = $this->db->select("c_id,sender,message,conn_time","connectM","c_id='$this->c_id' GROUP BY conn_time");
			echo "<div id='display-contents'>";
			if($result){
				while($row = mysqli_fetch_array($result)){
					$sender = $row[1];
					$message = $row[2];
					$sendTime = $row[3];
					// 自己放右边
					if ($sender == "employee") {
						echo 
						"<p style='font-size:15px;position: relative;left:460px;height:0px;'>$sendTime</p><div class='c2e'>".
							"<div class='c2e-content'>$message</div>".
							"<img src='$e_img_path' class='head-portrait' width=50px height=50px>".
						"</div>";
					}
					// 对方放左边
					else if($sender == "customer"){
						
						echo 
						"<p style='font-size:15px;position: relative;left:80px;height:0px;'>$sendTime</p><div class='e2c'>".
							"<img src='$c_img_path' class='head-portrait' width=50px height=50px>".
							"<div class='e2c-content'>$message</div>".
						"</div>";
					}
				}
			}
			echo "</div>";
		}

		// 消息输入区
		private function input_text() {
			echo
			"<div id='input-text'>".
				"<form action='saveSend.php?c_id=$this->c_id&flag=reply' method='post'>".
					"<textarea name='content' id='text'></textarea>".
					"<br><input type='submit' value='发&emsp;送' ><br>".
				"</form>".
			"</div>";
			
			
		}


		// 显示聊天界面
		public function chat_frame() {
			// 聊天窗体区域
			echo "<div id='chat'>";

			// 显示客户信息
			$this->emp_inf();
			// 显示所有聊天记录
			$this->all_contents();
			// 输出框
			$this->input_text();
			
			echo "</div>";
		}
		
	}
	
	?>
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
		.mainicon2{
			background: url("images/touxiang1.jpg") no-repeat;
			background-size: 60px;

			
			padding: 0px 0px 0px 0px;
			display: inline-block;
			margin: 0px 0px 0px 0px;
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
		
    	 #container{
			overflow-y:scroll; 
			overflow-x:hidden; 
			height:450px;
			border:3px solid #4037A9;
			 width:550px;
			margin: 20px 30px 20px 500px;
		}
	
      	html,body{margin:0px;padding:0px;font-family: "微软雅黑";}
		
            /*chat窗体 */
            #chat {
                position: absolute;
                left: 50%;
                margin-left: -450px;
                background-color: #F3F4F5;
                top: 20%;
            }
            #emp {
                position: relative; 
                width: 700px;
                height: 40px;
                border-style: solid;
                border-width: thick;
                border-color: gray;
            }
            #emp-inf {
                display: inline-block;
                position: absolute;
                top: 0.2em;
                left: 2em;
                margin: 0;
                font-family: KaiTi;
                font-size: 22px;
                font-weight: bold;
            }
            .head-portrait {
				border-radius: 5%;
				position:relative;
                top: 0.1em;
                left: 0.2em;
            }
            /*聊天记录*/
            #display-contents {
                width: 700px;
				overflow-y:auto; 
				overflow-x:hidden; 
				height:400px;
                border-style: solid;
                border-width: thick;
                border-color: gray;
                position: relative;
            }
            .c2e {
                text-align: right;
                margin: 5px 10px 20px auto;
                position: relative;
            }
            .e2c {
                margin: 5px auto 20px 10px;
                position: relative;
            }
            .c2e-content {
                display: inline-block;
                font-size: 20px;
                font-family: KaiTi;
				min-height: 30px;
				max-width: 400px;
				word-break: break-all;
                background-color: #9EEA6A;
                position: absolute;
                top: 5px;
                right: 65px;
                text-align: left;
                padding: 5px;
                border-radius: 10px;
            }
            .e2c-content {
				display: inline-block;
                font-size: 20px;
                font-family: KaiTi;
				min-height: 30px;
				max-width: 400px;
				word-break: break-all;
                position: absolute;
                top: 5px;
                left: 70px;
                text-align: left;
                padding: 5px;
                border-radius: 10px;
                background-color:aqua;
				
            }
            /*消息输入框 */
            textarea {
                width: 695px;
                height: 100px;
                font-size: 20px;
                font-family: KaiTi;
            }
            #input-text {
                width: 700px;
                border-style: solid;
                border-width: thick;
                border-color: gray;
                text-align: center;
            }
            input[type='submit'] {
                font-family: KaiTi;
                font-size: 25px;
                width: 100px;
                height: 40px;
				background-color: aquamarine;
				border-radius: 5%;
            }
            input[type='submit'] {
                cursor: pointer;
            }
    </style>

<body>
	<?php
		
		include("../style.php");
		judge();
		nav();

		$tip = "客户管理";
		$memuId = "menu-item-3";
		$tip1 = '查看客户消息';
		$tip2 = '回复客户消息';
		$e_id = $_COOKIE["e_id"];
		$c_id = $_GET["cid"];

		echo "<a href='mainUI.php'><span class='mainicon'><font class='fontstyle'>$tip</font></span></a>";
		echo "<a href='message.php?eid=$e_id&state=未读'><span class='righticon'><font class='fontstyle'>$tip1</font></span></a>";
		echo "<span class='righticon'><font class='fontstyle'>$tip2</font></span><Br>";
		$message = new Message($c_id,$e_id);
		$message->chat_frame();

		echo "<script>
			document.getElementById('$memuId').style.fontWeight='bold';
			document.getElementById('$memuId').style.color='#F4606C';
			document.getElementById('$memuId').style.textShadow='0px 0px 2px';";
		echo	"
			/*修改每个信息显示区的高度*/
			var all_content_divs = [...(document.getElementsByClassName('c2e-content')), 
			...(document.getElementsByClassName('e2c-content'))];
			for (var i = 0; i < all_content_divs.length; i++) {
				var content = all_content_divs[i].innerHTML;
				/* 根据行数确定高度（一行15个汉字，一行给25px高度）*/
				var height = Math.ceil(content.length / 15) * 25;
				/* 小于等于75直接跳过 */
				if (height <= 75) {
					continue;
				}
				/* 设置高度 */
				all_content_divs[i].style.height = height + 'px';
				all_content_divs[i].parentNode.style.height = (height + 10) + 'px';
			}

			/* 将滚动条拉到最下面 */
			var ele = document.getElementById('display-contents');
			ele.scrollTop = ele.scrollHeight;
		";
		echo "</script>";
	?>
</body>
</html>