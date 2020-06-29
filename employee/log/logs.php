<?php
	include("../function.php");
	class employee_logs{
//		private $employee_logs_id;
//		private $employee_logs_e_id;
//		private $employee_logs_time;
//		private $employee_logs_table;
//		private $employee_logs_operation;
//		private $employee_logs_key;
		private $db;
		public function __construct(){
			$this->db = new database();
			
		}
		public function insert_employees_logs($e_id,$table,$operation,$key){
			$this->db = new database();
			date_default_timezone_set("Asia/Shanghai");
			$time = date('Y-m-d H:i:s');
			
			$result=$this->db->insert("employees_logs","e_id,time,table_name,operation,key_value","'$e_id','$tmp','$table','$operation','$key'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('插入日志失败！');
				</script>";
				return false;
			}
		}
		public function insert_employees_logs($e_id,$table,$operation,$key){
			$this->db = new database();
			date_default_timezone_set("Asia/Shanghai");
			$time = date('Y-m-d H:i:s');
			
			$result=$this->db->insert("employees_logs","e_id,time,table_name,operation,key_value","'$e_id','$time','$table','$operation','$key'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('插入日志失败！');
				</script>";
				return false;
			}
		}
		public function insert_customers_logs($c_id,$table,$operation,$key){
			$this->db = new database();
			date_default_timezone_set("Asia/Shanghai");
			$time = date('Y-m-d H:i:s');
			
			$result=$this->db->insert("customers_logs","c_id,time,table_name,operation,key_value","'$c_id','$time','$table','$operation','$key'");
			if($result){
				return true;
			}else{
				echo "<script language=javascript>window.alert('插入日志失败！');
				</script>";
				return false;
			}
		}
	}
?>