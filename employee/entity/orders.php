<?php
	include("../function.php");
	include("goods.php");
	class orders{
		private $order_c_id;
		private $order_connect;
		private $order_address;
		private $order_delivery_fee;
		private $order_g_id;
		private $order_number;
		private $order_e_id;
		private $order_time;
		private $order_state;
		private $order_totalprice;
		private $order_tax_rate;
		private $db;
		public function __construct(){
			$this->db = new database();
			
		}
		 //生成订单     
		public function insertOrder($c_id,$connect,$address,$delivery_fee,$g_id,$number,$tax_rate)     {         
			$this->db = new database();	
			date_default_timezone_set("Asia/Shanghai");
			$time = date('Y-m-d H:i:s');
			$goods = new goods($g_id);
			$price = $goods->returnPrice();
			$totalprice = ($number*$price)*(1+$tax_rate)+$delivery_fee;
			$result = $db->insert("orders","c_id,o_connect,o_address,delivery_fee,g_id,o_number,e_id,o_time,o_state,totalprice,tax_rate","'$c_id','$connect','$address','$delivery_fee','$g_id','$number','null','$time','未配送','$totalprice','$tax_rate'");         
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('订单生成失败！');
				</script>";
				return false;
			}
		} 
 		public function updateEmployee($e_id,$o_id){
			$this->db = new database();	
			$result = $this->db->update("orders","e_id=$e_id","o_id = '$o_id'");
			        
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('员工更新失败！');
				</script>";
				return false;
			}
		}
 
		
	}
?>