<?php
	include("function.php");
	class customer{
		private $customer_id;
		private $customer_user;
		private $customer_password;
		private $customer_connect;
		private $customer_score;
		private $customer_money;
		private $customer_address;
		private $customer_level;
		private $customer_cprice;
		private $customer_state;
		private $customer_sex;
		private $db;
		public function __construct($username,$password){
			$this->db = new database();
			$result = $this->db->select("c_id,c_connect,c_score,c_money,c_address,level,consump_price,c_state,c_sex","customer","c_username='$username' AND password='$password'");
			$this->customer_user = $username;
			$this->customer_pass = $password;
			if($row = mysqli_fetch_array($result)){
				$this->customer_id = row[0];
				$this->customer_connect = row[1];
				$this->customer_score = row[2];
				$this->customer_money = row[3];
				$this->customer_address = row[4];
				$this->customer_level = row[5];
				$this->customer_cprice = row[6];
				$this->customer_state = row[7];
				$this->customer_sex = row[8];
			}else{
				echo "<script language=javascript>window.alert('用户创建失败！');
				</script>";
			}
		}
		public function Recharge($money) {
			$this->customer_money += $money;
			$result = $this->db->update("customer","c_money=$this->customer_money","c_id = '$this->customer_id'");
			if($result){
				echo "<script language=javascript>window.alert('充值成功！');
				</script>";
				return true;
			}else{
				echo "<script language=javascript>window.alert('充值失败！');
				</script>";
				return false;
			}
		}
		public function pay($money) {
			$this->customer_money -= $money;
			if($this->customer_money < 0){
				echo "<script language=javascript>window.alert('余额不足！');
				</script>";
				return false;
			}
			$result = $this->db->update("customer","c_money=$this->customer_money","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('余额更新失败！');
				</script>";
				return false;
			}
		}
		public function purchaseVIP1(){
			$this->customer_money -= 50;
			if($this->customer_money < 0){
				echo "<script language=javascript>window.alert('余额不足！');
				</script>";
				return false;
			}
			$result = $this->db->update("customer","c_money=$this->customer_money","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('VIP购买失败！');
				</script>";
				return false;
			}
		}
		public function purchaseVIP2(){
			$this->customer_score -= 2000;
			if($this->customer_score < 0){
				echo "<script language=javascript>window.alert('积分不足！');
				</script>";
				return false;
			}
			$result = $this->db->update("customer","c_score=$this->customer_score","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('VIP购买失败！');
				</script>";
				return false;
			}
		}
		public function addScore($fee) {
			$this->customer_score += $fee;
			$result = $this->db->update("customer","c_score=$this->customer_score","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('积分更新失败！');
				</script>";
				return false;
			}
		}
		public function editData($sex,$user,$connect,$address){
			$this->customer_user = $user;
			$this->customer_connect = $connect;
			$this->customer_address = $address;
			$this->customer_sex = $sex;
			$result = $this->db->update("customer","c_username=$this->customer_user,c_sex=$this->customer_sex,c_connect=$this->customer_connect,c_address=$this->customer_address","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('资料编辑失败！');
				</script>";
				return false;
			}
		}
		public function block(){
			$this->customer_state = "blocked";
			$result = $this->db->update("customer","c_state=$this->customer_state","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('拉黑失败！');
				</script>";
				return false;
			}
		}
		public function cancelBlock(){
			$this->customer_state = "normal";
			$result = $this->db->update("customer","c_state=$this->customer_state","c_id = '$this->customer_id'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('取消拉黑失败！');
				</script>";
				return false;
			}
		}
		public function returnId(){
			return $this->customer_id;
		}
		public function returnUser(){
			return $this->customer_id;
		}
		public function returnPassword(){
			return $this->customer_password;
		}	
		public function returnConnect(){
			return $this->customer_connect;
		}
		public function returnScore(){
			return $this->customer_score;
		}
		public function returnMoney(){
			return $this->customer_money;
		}
		public function returnAddress(){
			return $this->customer_address;
		}
		public function returnLevel(){
			return $this->customer_level;
		}
		public function returnCprice(){
			return $this->customer_cprice;
		}
	}
?>