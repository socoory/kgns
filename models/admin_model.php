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
		$sql 	= 'SELECT * FROM user as U 
						LEFT JOIN (SELECT * FROM groups) as G 
						ON U.group_id = G.group_id
				  '.$where.' LIMIT '.$limit['start'].', '.$limit['end'];
		return $this->query_result($sql, ($group_id ? array($group_id) : null));
	}
	
	function getGroupInfoByGroupId($g_id) {
		$sql = 'SELECT *FROM groups where group_id = ?';
		return $this->query_row($sql, array($g_id));
	}
	
	function editGroupInfo($info) {
		$sql = 'UPDATE groups SET group_name = ? where group_id = ?';
		return $this->query_exec($sql, $info);
	}
	
	function deleteGroup($g_id) {
		$sql = 'DELETE from groups where group_id = ?';
		return $this->query_exec($sql, $g_id);
	}
	
	function addGroup($g_name) {
		$sql = 'INSERT INTO groups(group_name) value(?)';
		return $this->query_exec($sql, array($g_name));
	}
	
	function groupJoin() {
		$sql = 'SELECT G.group_id, G.group_name, U.cnt FROM groups as G LEFT JOIN (SELECT group_id, COUNT(*) cnt FROM user GROUP BY group_id) as U ON G.group_id=U.group_id';
		return $this->query_result($sql, null);
	}

	function getPostByLimit($limit, $group_id=null) {
		$where 	= $group_id ? 'WHERE group_id = ?' : '';
		$sql 	= 'SELECT * FROM post as U 
						LEFT JOIN (SELECT * FROM groups) as G 
						ON U.group_id = G.group_id
				  '.$where.' LIMIT '.$limit['start'].', '.$limit['end'];
		return $this->query_result($sql, ($group_id ? array($group_id) : null));
		
		
	}
	
}

?>