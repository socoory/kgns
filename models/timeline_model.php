<?php
if (!defined("__KGNS__")) exit;

class Timeline_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	//*******************************************************//
	//                          get                          //
	//*******************************************************//
	
	function getPosts() {
		return $this->query_result('SELECT * FROM post ORDER BY post_id DESC', null);
	}
	
	
	//*******************************************************//
	//                         insert                        //
	//*******************************************************//
	
	function post($info) {
		$sql = "INSERT INTO post (contents, user_id, user_name, user_profile_image, group_id, regdate)
				VALUES (?, ?, ?, ?, ?, NOW())";
				
		return $this->query_exec($sql, $info);
	}
}

?>