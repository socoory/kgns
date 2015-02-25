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
		$sql = 'UPDATE user SET email = ?, name = ?, group_id = ? where id = ?';
		return $this->query_exec($sql, $info);
	}
	
	function delete_user($info) {
		$sql = 'DELETE from user where id = ?';
		return $this->query_exec($sql, $info);
	}
	
	function getTotalPage($table, $where=null, $num=10) {
		$sql = 'SELECT COUNT(*) as num from '.$table.' ';
		
		if($where != null)
			$sql .= 'where '.$where;

		$res 		= $this->query_row($sql, null);
		$numPages 	= ceil($res->num/$num);
		
		return $numPages;
	}
	
	function getUsersByLimit($limit, $group_id=null) {
		$where 	= $group_id ? 'WHERE group_id = ?' : '';
		$sql 	= 'SELECT * FROM user '.$where.' LIMIT '.$limit['start'].', '.$limit['end'];
		return $this->query_result($sql, ($group_id ? array($group_id) : null));
	}
	
	function editGroupInfo($info) {
		$sql = 'UPDATE groups SET group_id = ?, group_name = ?';
		return $this->query_exec($sql, $info);
	}
	
}

?>