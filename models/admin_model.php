<?php

Class Admin_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	function loadAdminInfo($info) {
		$sql = 'SELECT * FROM admin_user where email = ?';
		return $this->query_row($sql, $info);
	}
	
	function getTotalPage($table, $where=null, $num=10) {
		$sql = 'SELECT COUNT(*) as num from '.$table.' ';
		
		if($where != null)
			$sql .= 'where '.$where;

		$res 		= $this->query_row($sql, null);
		$numPages 	= ceil($res->num/$num);
		
		return $numPages;
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