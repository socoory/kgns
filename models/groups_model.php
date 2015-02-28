<?php
Class Groups_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	// --------------------------------------------------------------------
	/**
	 * create group
	 *
	 * @author DoJong
	 * @since 2015.02.28
	 *
	 * @param string
	 *
	 * @return bool
	 */
	function createGroup($groupName) {
		$sql = '
					INSERT INTO
						groups
						(group_name)
					VALUE
						(?)
				';
		return $this->query_exec($sql, array($groupName));
	}
	
	// --------------------------------------------------------------------	
	/**
	 * get group info by groupId
	 *
	 * @author DoJong
	 * @since 2015.02.28
	 *
	 * @param int
	 *
	 * @return object
	 */
	function getGroupInfoByGroupId($groupID) {
		$sql = '
					SELECT
						*
					FROM
						groups
					WHERE
						group_id = ?
				';
		return $this->query_row($sql, array($groupID));
	}
	
	// --------------------------------------------------------------------	
	/**
	 * update group info
	 *
	 * @author DoJong
	 * @since 2015.02.28
	 *
	 * @param string
	 * @param int
	 *
	 * @return bool
	 */
	function updateGroupInfo($groupName, $groupID) {
		$sql = '
					UPDATE
						groups
					SET
						group_name = ?
					WHERE
						group_id = ?
				';
		return $this->query_exec($sql, array($groupName, $groupID));
	}

	// --------------------------------------------------------------------	
	/**
	 * delete group
	 * 
	 * @author DoJong
	 * @since 2015.02.28
	 *
	 * @param int
	 *
	 * @return bool
	 */
	function deleteGroup($groupID) {
		$sql = '
					DELETE
					FROM
						groups
					WHERE
						group_id = ?
				';
		return $this->query_exec($sql, array($groupID));
	}
	
	// --------------------------------------------------------------------	
	/**
	 * get group info
	 * 
	 * @author DoJong
	 * @since 2015.02.28
	 *
	 * @return object
	 */	
	function getGroupInfo() {
		$sql = '
					SELECT
						G.group_id,
						G.group_name,
						U.cnt
					FROM
						groups as G 
					LEFT JOIN
						(
						SELECT
							group_id,
							COUNT(*) cnt
						FROM
							user
						GROUP BY
							group_id
						) as U
					ON
						G.group_id = U.group_id
				';
		return $this->query_result($sql, null);
	}	
}
?>