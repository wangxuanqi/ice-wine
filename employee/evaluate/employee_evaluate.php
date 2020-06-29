<?php
	include("../function.php");
	class employee_logs{
		private $employee_logs_id;
		private $employee_logs_e_id;
		private $employee_logs_time;
		private $employee_logs_table;
		private $employee_logs_operation;
		private $employee_logs_key;
		private $db;
		public function __construct(){
			$this->db = new database();
			
		}
		
		
	}
?>