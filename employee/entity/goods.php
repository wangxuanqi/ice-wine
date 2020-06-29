<?php
	include("function.php");
	class goods{
		private $goods_id;
		private $goods_name;
		private $goods_price;
		private $goods_cost;
		private $goods_birth;
		private $goods_qperiod;
		private $goods_number;
		private $goods_threshold;
		private $db;
		public function __construct($id){
			$this->db = new database();
			$result = $this->db->select("g_name,g_price,g_cost,g_birth,g_qperiod,g_number,g_threshold","storehouse","g_id='$id'");
			$this->goods_id = $id;
			if($row = mysqli_fetch_array($result)){
				$this->goods_name = row[0];
				$this->goods_price = row[1];
				$this->goods_cost = row[2];
				$this->goods_birth = row[3];
				$this->goods_qperiod = row[4];
				$this->goods_number = row[5];
				$this->goods_threshold = row[6];
			}else{
				echo "<script language=javascript>window.alert('商品创建失败！');
				</script>";
			}
		}
		public function returnId(){
			return $this->goods_id;
		}
		public function returnName(){
			return $this->goods_name;
		}
		public function returnPrice(){
			return $this->goods_price;
		}
		public function returnCost(){
			return $this->goods_cost;
		}
		public function returnBirth(){
			return $this->goods_birth;
		}
		public function returnQperiod(){
			return $this->goods_qperiod;
		}
		public function returnNumber(){
			return $this->goods_number;
		}
		public function returnThreshold(){
			return $this->goods_threshold;
		}
		
	}
?>