<?php

class Attach_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	// ----------------------------------------------------------------------
	/**
	 * create an attach record
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param array
	 * 			user_id		: int
	 * 			file_url	: string
	 * 			type		: char - image 'i' or common-file 'f'
	 * 			file_name	: string
	 * 
	 * @return int
	 */
	function attach($info) {
		$sql = '
					INSERT INTO
						attach
						(
							attach_id,
							user_id,
							file_url,
							type,
							file_name,
							regdate
						)
					VALUES
						(
							LAST_INSERT_ID(),
							?, ?, ?, ?,
							NOW()
						)
				';
		return $this->query_exec($sql, $info);
	}
	
	// ----------------------------------------------------------------------
	/**
	 * get attahed file list
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param int
	 * @param char
	 * @param int (default null)
	 * 
	 * @return object array
	 */
	function getAttaches($postId, $type, $count=null) {
		if($count == null) {
			$sql = '
						SELECT
							*
						FROM
							attach
						WHERE
							post_id = ?
							AND type = ?
						ORDER BY
							attach_id ASC
					';
					
			return $this->query_result($sql, array($postId, $type));
		}
		else {
			$sql = '
						SELECT *
						FROM
							attach
						WHERE
							post_id = ?
						AND type = ?
						ORDER BY
							attach_id ASC
						LIMIT '.$count.'
					';
			
			return $this->query_result($sql, array($postId, $type));
		}
	}

	// ----------------------------------------------------------------------
	/**
	 * update post(parent) id of attached files
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param array
	 * @param int
	 * 
	 * @return int
	 */
	function insertAttachPostId($idList, $id) {
		$sql = '
					UPDATE
						attach
					SET
						post_id = '.$id.'
					WHERE
						attach_id IN ('.$idList.')';
						
		return $this->query_exec($sql, null);
	}
}

?>