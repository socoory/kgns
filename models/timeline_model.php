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
			$row->comments = $this->getComments($row->post_id, 3);
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
	
	
	//*******************************************************//
	//                         insert                        //
	//*******************************************************//
	
	function post($info) {
		$sql = "INSERT INTO post (contents, user_id, user_name, user_profile_image, group_id, regdate)
				VALUES (?, ?, ?, ?, ?, NOW())";
				
		return $this->query_exec($sql, $info);
	}
	
	function comment($info) {
		$sql = "INSERT INTO comment (post_id, contents, user_id, user_name, user_profile_image, regdate)
				VALUES (?, ?, ?, ?, ?, NOW())";
				
		return $this->query_exec($sql, $info);
	}
}

?>