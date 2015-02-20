<?php

class Attach_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	function attach($info) {
		$sql = 'INSERT INTO attach(attach_id, user_id, file_url, type, file_name, regdate) VALUES(LAST_INSERT_ID(), ?, ?, ?, ?, NOW())';
		return $this->query_exec($sql, $info);
	}
	
	function getAttaches($post_id) {
		return $this->query_result("SELECT * FROM attach WHERE post_id = ?", array($post_id));
	}
	
	function insertAttachPostId($idList, $id) {
		$sql = "UPDATE attach SET post_id=$id WHERE attach_id IN ($idList)";
		return $this->query_exec($sql, null);
	}
	
	function insertId() {
		return $this->query_row('SELECT LAST_INSERT_ID() as id', null)->id;
	}
}

?>