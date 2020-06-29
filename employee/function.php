<?php
	class database{
		private $connect;
		//私有化构造函数，防止外界实例化对象 
		public function __construct(){
			include("conn.php");
			$this->connect = $conn;
		}
		 //私有化克隆函数，防止外界克隆对象     
		private function __clone(){} 
		 //数据库查询操作     
		public function query($sql){         
			$res = mysqli_query($this->connect, $sql);                     
			if (strpos($sql,'SELECT') !== false) {             
				if ($res) {                 
					$result = mysqli_fetch_all($res);             
				}else{                 
					return false;             
				}         
			}         
			return $result;     
		} 
		//查询数据 
		function select($field = '', $table = '', $where ='') {         
			if ($field=='') {         
				if ($where=='') {             
					$sql = "SELECT * FROM ".$table;         
				} else {             
					$sql = "SELECT * FROM ".$table." WHERE ".$where;        
				}     
			} else if ($where == '') {         
				$sql = "SELECT ".$field." FROM ".$table;    
			} else {        
				$sql = "SELECT ".$field." FROM ".$table." WHERE ".$where;     
			}   
			$res = mysqli_query($this->connect, $sql);   
			return $res; 
		} 
 		//更新数据 
		function update($table='', $set='', $where='') {     
			     
			$sql = "UPDATE ".$table." SET ".$set." WHERE ".$where;     
			$res = mysqli_query($this->connect, $sql); 
			echo $sql;
			return $res; 
		} 
		//新增数据 
		function insert($table='', $field='', $value='') {          
			$sql = "INSERT INTO ".$table." ".$field." VALUES ".$value;   
			echo $sql;
			$res = mysqli_query($this->connect, $sql);   
			return $res; 
		} 
 		//删除数据 
		function delete($table, $where) {         
			$sql = "DELETE FROM ".$table." WHERE ".$where; 
      	    $res = mysqli_query($this->connect, $sql);    
			return $res; 
		} 
 
	};
	function showTable($tablename){ //
		include ("conn.php");
		$sql = "SHOW FULL COLUMNS FROM $tablename"; //获取表格的所有字段名
		$columeResult = mysqli_query($conn,$sql);
		$numOfColume = 0;
		$colume = array();

		echo "<table class='table4_5' border='1' bordercolor = '#000000' style = 'text-align: center;margin: 0 auto'>
			<caption class = 'tabletitle'>
				<strong>
					$tablename
				</strong>
			</caption>
			<tr>";
		while ($row = mysqli_fetch_row($columeResult)) {
			echo "<th class = 'colume'>$row[0]</th>";
			$colume[$numOfColume] = $row[0];
			$numOfColume++;
		}
		//echo $numOfColume;
		echo "</tr>";

		$order = "select * FROM $tablename";         //获取表格的所有内容
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
	}
	function judge_signIn($username,$password){
		$db = new database();
		$result = $db->select("password","customers","c_username='$username'");
		if($row = mysqli_fetch_array($result)){
			if($password == $row[0])
				return true;
			else{
				echo "<script language=javascript>window.alert('密码错误！');
			</script>";
			return false;
			}
				
		}else{
			echo "<script language=javascript>window.alert('用户名不存在！');
			</script>";
			return false;
		}
	}
	
	function judge(){
		include("conn.php");
		// 返回登录
		$back_to_login = "../../login_register/login_register.php";
		if(is_array($_COOKIE)&&count($_COOKIE)>0)//先判断是否通过get传值了
		{
			if(isset($_COOKIE["e_id"]))//是否存在"id"的参数
			{
				$eid = $_COOKIE["e_id"];//存在

			}else{
				echo 
				"<script language=javascript>
					window.location.href = '$back_to_login';
				</script>";
			}
			if(isset($_COOKIE["e_pwd"]))//是否存在"id"的参数
			{
				$epsw = $_COOKIE["e_pwd"];//存在

			}else{
				echo 
				"<script language=javascript>
					window.location.href = '$back_to_login';
				</script>";
			}
		}else{
			echo 
			"<script language=javascript>
				window.location.href = '$back_to_login';
			</script>";
		}
		$db = new database();
		$result = $db->select("e_pwd","employee","e_id='$eid'");
		if($row = mysqli_fetch_array($result)){
			if($epsw == $row[0])
				return true;
			else{
				echo 
				"<script language=javascript>
					window.location.href = '$back_to_login';
				</script>";
				return false;
			}
				
		}else{
			echo 
			"<script language=javascript>
				window.location.href = '$back_to_login';
			</script>";
			return false;
		}
	}

?>