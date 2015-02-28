<?php if (!defined("__KGNS__")) exit;

class Comment_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	// ----------------------------------------------------------------------
	/**
	 * get comments
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param int
	 * @param int (default null)
	 * 
	 * @return int
	 */
	function getComments($postId, $count=null) {
		if($count == null) {
			$sql = '
						SELECT *
						FROM
							comment
						WHERE
							post_id = ?
						ORDER BY
							comment_id
					';
					
			return $this->query_result($sql, array($postId));
		}
		else {
			$sql = '
						SELECT
							*
						FROM 
							(
							SELECT *
							FROM
								comment
							WHERE
								post_id = ?
							ORDER BY
								comment_id DESC
							LIMIT '.$count.'
							) sub
						ORDER BY
							comment_id ASC
					';
					
			return $this->query_result($sql, array($postId));
		}
	}
	
	// ----------------------------------------------------------------------
	/**
	 * create a comment record
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param int
	 * @param string
	 * @param array
	 * 			user_id				=> int
	 * 			user_name			=> string
	 * 			user_profile_name	=> string: url
	 * 
	 * @return int
	 */
	function comment($postId, $contents, $user) {
		$sql = '
					INSERT INTO
						comment
						(
							post_id,
							contents,
							user_id,
							user_name,
							user_profile_image,
							regdate
						)
					VALUES
					(
						?, ?, ?, ?, ?,
						NOW()
					)';
				
		return $this->query_exec($sql, $info);
	}
}

?>