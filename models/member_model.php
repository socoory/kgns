<?php
	class Member_model extends Model {
		function __construct($db) {
			parent::__construct($db);
		}
		
		function regist($info) {
			$sql = 'INSERT INTO user(email, name, password, group_id, regdate)
					VALUES(?, ?, ?, ?, now())';
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
		
		function loadGroupInfo() {
			$sql = 'SELECT * FROM groups';
			return $this->query_result($sql, null);
		}
		
		function loadUserInfo($info) {
			$sql = 'SELECT * FROM user where email = ?';
			return $this->query_row($sql, $info);
			
		}
		
		function edit($info1, $info2) {
			$sql1 = 'UPDATE user SET email = ?, name = ?, password =?, group_id = ?, regdate = now() where id = ?';					
			$this->query_exec($sql1, $info1);
			$sql2 = 'SELECT * FROM user where email = ?';
			return $this->query_row($sql2, $info2);
		}
	}
?>