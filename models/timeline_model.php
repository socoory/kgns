<?php
if (!defined("__KGNS__")) exit;

class Timeline_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	//*******************************************************//
	//                          get                          //
	//*******************************************************//
	
	function getPost($post_id) {
		return $this->query_row('SELECT * FROM post
									 WHERE post_id = ?', array($post_id));
	}
	
	function getPosts() {
		$res =  $this->query_result('SELECT * FROM post
									 ORDER BY post_id DESC', null);
									 
		foreach($res as $row) {
			$row->comments 	  = $this->getComments($row->post_id, 3);
			$row->attachImage = $this->getAttaches($row->post_id, 'i', 3);
			$row->attachFile  = $this->getAttaches($row->post_id, 'f', 3);
		}
		
		return $res;
	}
	
	function getComments($postId, $count=null) {
		if($count == null)
			return $this->query_result('SELECT * FROM comment WHERE post_id = ?
										ORDER BY comment_id', array($postId));
		else
			return $this->query_result('SELECT * FROM 
											(SELECT * FROM comment WHERE post_id = ?
											ORDER BY comment_id DESC LIMIT '.$count.') sub
										ORDER BY comment_id ASC'
									    , array($postId));
	}
	
	function getAttaches($postId, $type, $count=null) {
		if($count == null)
			return $this->query_result("SELECT * FROM attach WHERE post_id = ? AND type = ?", array($post_id, $type));
		else
			return $this->query_result('SELECT * FROM attach WHERE post_id = ? AND type = ?
										ORDER BY attach_id DESC LIMIT '.$count, array($postId, $type));
	}
	
	function insertId() {
		return $this->query_row("SELECT LAST_INSERT_ID() as id", null)->id;
	}
	
	
	//*******************************************************//
	//                         insert                        //
	//*******************************************************//
	
	function post($info) {
		$sql = "INSERT INTO post (post_id, contents, user_id, user_name, user_profile_image, group_id, regdate)
				VALUES (LAST_INSERT_ID(), ?, ?, ?, ?, ?, NOW())";
				
		return $this->query_exec($sql, $info);
	}
	
	function comment($info) {
		$sql = "INSERT INTO comment (post_id, contents, user_id, user_name, user_profile_image, regdate)
				VALUES (?, ?, ?, ?, ?, NOW())";
				
		return $this->query_exec($sql, $info);
	}
}

?>