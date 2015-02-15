<?php

Class Admin_model extends Model {
	function __construct($db) {
			parent::__construct($db);
		}
	
	function loadAdminInfo($info) {
			$sql = 'SELECT * FROM admin_user where email = ?';
			return $this->query_row($sql, $info);		
	}
	
	function edit_user($info) {
		$sql = 'UPDATE user SET email = ?, name = ?, group_id = ? where email = ?';
		return $this->query_exec($sql, $info);
	}
	
	function delete_user($info) {
		$sql = 'DELETE from user where id = ?';
		return $this->query_exec($sql, $info);
	}
	
}

?>