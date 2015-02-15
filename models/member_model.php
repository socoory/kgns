<?php
class Member_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	function regist($info) {
		$sql = 'INSERT INTO user(email, name, password, group_id, profile_image, regdate)
				VALUES(?, ?, ?, ?, ?, now())';
		return $this->query_exec($sql, $info);
	}
	
	function getUsers() {
		$sql = 'SELECT * FROM user';
		return $this->query_result($sql, null);
	}
	
	function getUserById($id) {
		$sql = 'SELECT * FROM user where id = ?';
		return $this->query_row($sql, array($id));			
	}
	
	function getUserByGroup($group) {
		$sql = 'SELECT * FROM user where group_id = ?';
		return $this->query_result($sql, $group);
		
	}
	
	function loadGroupInfo() {
		$sql = 'SELECT * FROM groups';
		return $this->query_result($sql, null);
	}
	
	function loadUserInfo($info) {
		$sql = 'SELECT * FROM user where email = ?';
		return $this->query_row($sql, $info);
		
	}
	
	function loadEmailInfo($info) {
		$sql = 'SELECT email FROM user';
		return $this->query_result($sql, null); 
	}
	
	function edit($info) {
		$sql1 = 'UPDATE user SET email = ?, name = ?, password =?, group_id = ?, profile_image = ?, regdate = now() where id = ?';					
		$this->query_exec($sql1, $info);
		$sql2 = 'SELECT * FROM user where email = ?';
		return $this->query_row($sql2, array($info[0]));
	}
}
?>