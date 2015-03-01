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
			return $this->query_result("SELECT * FROM attach WHERE post_id = ? AND type = ? ORDER BY attach_id ASC", array($post_id, $type));
		else
			return $this->query_result('SELECT * FROM attach WHERE post_id = ? AND type = ?
										ORDER BY attach_id ASC LIMIT '.$count, array($postId, $type));
	}
	
	function getActivity($activity_info) {
		$sql = 'select * from activity where user_id = ? and activity_id > ? ORDER BY activity_id ASC';
		return $this->query_result($sql, $activity_info);
	}
	
	function getPostUserId($post_id) {
		$sql = 'SELECT user_id FROM post WHERE post_id = ?';
		return $this->query_row($sql, $post_id)->user_id;
	}

	function getCommentUserId($post_id) {
		$sql = 'SELECT DISTINCT user_id FROM comment WHERE post_id = ?';
		return $this->query_result($sql, $post_id);
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
		$sql = "INSERT INTO comment (comment_id, post_id, contents, user_id, user_name, user_profile_image, regdate)
				VALUES (LAST_INSERT_ID(), ?, ?, ?, ?, ?, NOW())";
				
		return $this->query_exec($sql, $info);
	}
	
	function activity($info) {
		$sql = "INSERT INTO activity (user_id, activity_type, source_id, parent_id, regdate)
		VALUES(?, ?, ?, ?, ?, NOW())";
		//user_id = 알림창을 띄울 user의 id, activity_type = 1:글작성, 2:좋아요, 3:싫어요, source_id = 글을 작성한 user_id
		//parent_id = post 대상이 되는 post_id
		return $this->query_exec($sql, $info); 
	}
	
	function activity_comment($activity_comment_info) {
		$sql = "INSERT INTO activity (user_id, activity_type, source_id, parent_id, regdate) 
		VALUES ".$activity_comment_info;
		return $this->query_exec($sql, null);

	}
		
	function test_($info) {
		$sql = 'SELECT * FROM user where id > ? ORDER BY id DESC';
		return $this->query_row($sql, $info); 
	}
}

?>