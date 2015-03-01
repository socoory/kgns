<?php
if (!defined("__KGNS__")) exit;

class Post_model extends Model {
	function construct($db) {
		parent::__construct($db);
	}
	
	// ----------------------------------------------------------------------
	/**
	 * get a post
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param int
	 * 
	 * @return object
	 */
	function getPost($post_id) {
		$sql = '
					SELECT
						*
					FROM
						post
					WHERE
						post_id = ?
				';
				
		return $this->query_row($sql, array($post_id));
	}
	
	// ----------------------------------------------------------------------
	/**
	 * get posts
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @return object
	 */
	function getPosts() {
		$sql = '
					SELECT
						*
					FROM
						post
					ORDER BY
						post_id DESC
				';
		
		$res =  $this->query_result($sql, null);
		
		return $res;
	}
	
	// ----------------------------------------------------------------------
	/**
	 * create a post record
	 * 
	 * @author Benimario
	 * @since 2015.02
	 *
	 * @param string
	 * @param array
	 * 			user_id 			=> int
	 * 			user_name 			=> string
	 * 			user_profile_image 	=> string: url
	 * 			user_group_id 			=> int
	 * 
	 * @return int
	 */
	function post($content, $user) {
		$sql = '
					INSERT INTO
						post
							(
							post_id,
							contents,
							user_id,
							user_name,
							user_profile_image,
							group_id,
							regdate
							)
					VALUES
						(
						LAST_INSERT_ID(),
						?, ?, ?, ?, ?,
						NOW()
						)
				';
				
		$info = array(
			$content,
			$user['user_id'],
			$user['user_name'],
			$user['user_profile_image'],
			$user['user_group_id']
		);

		return $this->query_exec($sql, $info);
	}
}

?>