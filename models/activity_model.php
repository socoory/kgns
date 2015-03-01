<?php if (!defined("__KGNS__")) exit;
Class Activity_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	// --------------------------------------------------------------------
	/**
	 * get last activity_id by user_id
	 *
	 * @author Waldo
	 * @since 2015.03.01
	 *
	 * @param int
	 *
	 * @return object
	 */
	function getLatestActivity($user_id) {
		$sql = '
					SELECT
						MAX(activity_id) as activity_id
					FROM
						activity
					WHERE
						source_id = ?
				';
		return $this->query_row($sql, array($user_id));
	}
	
	// --------------------------------------------------------------------
	/**
	 * get activities by user_id and activity_id
	 *
	 * @author Waldo
	 * @since 2015.03.01
	 *
	 * @param int
	 * @param int
	 *
	 * @return object
	 */
	function getActivity($user_id, $activity_id) {
		$sql = 'SELECT 
					* 
				FROM
					activity 
				WHERE
					user_id = ? and activity_id > ? ORDER BY activity_id ASC
				';	
		return $this->query_result($sql, array($user_id, $activity_id));
	}
	
	// --------------------------------------------------------------------
	/**
	 * create a activity record
	 *
	 * @author Waldo
	 * @since 2015.03.01
	 *
	 * @param int : user_id 	알림창을 띄울 user_id
	 * @param int :	activity_id 1:Post, 2:Comment 3:Like, 4:Dislike
	 * @param int : source_id	글을 작성한 user_id
	 * @param int : parent_id	해당하는 post_id
	 *
	 * @return object
	 */
	function activity($user_id, $activity_type, $source_id, $parent_id) {
		$sql = '
					INSERT INTO 
						activity
						(
							user_id, 			
							activity_type,	
							source_id, 
							parent_id,
							regdate
						)
					VALUES
					(
						?, ?, ?, ?, 
						NOW()
					)
				';
		return $this->query_exec($sql, array($user_id, $activity_type, $source_id, $parent_id)); 
	}
	// --------------------------------------------------------------------
	/**
	 * create a activity record
	 *
	 * @author Waldo
	 * @since 2015.03.01
	 *
	 * @param array(int, int, int, int) 
	 * user_id 		알림창을 띄울 user_id
	 * activity_id 	어떤 행동을 했는지 보여줌 1:Post, 2:Comment 3:Like, 4:Dislike
	 * source_id	글을 작성한 user_id
	 * parent_id	해당하는 post_id
	 *
	 * @return object
	 */
	function activity_comment($activity_comment_info) {
		$sql = '
					INSERT INTO 
						activity 
						(
							user_id, 
							activity_type, 
							source_id, 
							parent_id, 
							regdate
						) 
					VALUES ?
				';
		return $this->query_exec($sql, array($activity_comment_info));

	}
}
?>