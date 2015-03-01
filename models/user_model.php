<?php
Class User_model extends Model {
	function __construct($db) {
		parent::__construct($db);
	}
	
	// --------------------------------------------------------------------
	/**
	 * create user
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param int
	 * @param string: url
	 *
	 * @return bool
	 */
	function createUser($email, $name, $password, $groupId, $profileImage) {
		$sql = '
					INSERT INTO
						user
						(
							email,
							name,
							password,
							group_id,
							profile_image,
							regdate
						)
					VALUE
						(
							?, ?, ?, ?, ?,
							now()
						)
				';
		return $this->query_exec($sql, array($email, $name, $password, $groupId, $profileImage));
	}

	// --------------------------------------------------------------------
	/**
	 * get users
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @return object
	 */
	function getUsers() {
		$sql = '
					SELECT
						*
					FROM
						user
				';
		return $this->query_result($sql, null);
	}
	
	// --------------------------------------------------------------------
	/**
	 * get user by id
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 * 
	 * @param int
	 *
	 * @return object
	 */
	function getUserById($id) {
		$sql = '
					SELECT
						*
					FROM
						user
					WHERE
						id = ?
				';
		return $this->query_row($sql, array($id));			
	}
	
	// --------------------------------------------------------------------
	/**
	 * get user by groupId
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @param int
	 *
	 * @return object
	 */
	function getUserByGroupId($groupId) {
		$sql = '
					SELECT
						*
					FROM
						user
					WHERE
						group_id = ?
				';
		return $this->query_result($sql, array($groupId));		
	}

	// --------------------------------------------------------------------
	/**
	 * get user by email
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @param string
	 *
	 * @return object
	 */
	function getUserByEmail($email) {
		$sql = '
					SELECT
						*
					FROM
						user
					WHERE
						email = ?
				';
		return $this->query_row($sql, array($email));
	}
	
	// --------------------------------------------------------------------
	/**
	 * get user by limit
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 * 
	 * @param int
	 * @param int
	 *
	 * @return object
	 */
	function getUserByLimit($limit, $group_id=null) {
		$where 	= $group_id ? 'WHERE U.group_id = ?' : '';
		$sql = '
					SELECT 
						*
					FROM
						user as U
					LEFT JOIN
						(
						SELECT 
							*
						FROM
							groups
						) as G 
					ON
						U.group_id = G.group_id
				  '.$where.' LIMIT '.$limit['start'].', '.$limit['end'];
		return $this->query_result($sql, ($group_id ? array($group_id) : null));
	}
	
	// --------------------------------------------------------------------
	/**
	 * get eamils
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @return object
	 */
	function getEmails() {
		$sql = '
					SELECT
						email
					FROM
						user
				';
		return $this->query_result($sql, null); 
	}

	// --------------------------------------------------------------------
	/**
	 * update user info
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @param array
	 * 			$email			: string
	 * 			$name			: string
	 * 			$password		: string
	 * 			$group_id		: int
	 * 			$profile_image	: string: url
	 * 			$user_id		: int
	 *
	 * @return object
	 */
	function updateUserInfo($info) {
		$sql1 = '
					UPDATE
						user
					SET
						email = ?,
						name = ?,
						password =?,
						group_id = ?,
						profile_image = ?,
						regdate = now()
					WHERE
						id = ?
				';
				
		$this->query_exec($sql1, $info);
		
		$sql2 = '
					SELECT
						*
					FROM
						user
					WHERE
						email = ?
				';
				
		return $this->query_row($sql2, array($info[0]));
	}
	
	// --------------------------------------------------------------------
	/**
	 * update user info by Admin
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @param string
	 * @param string
	 * @param int
	 * @param int
	 *
	 * @return bool
	 */
	function updateUserByAdmin($email, $name , $group_id, $id) {
		$sql = '
					UPDATE
						user
					SET
						email = ?,
						name = ?,
						group_id = ?
					WHERE
						id = ?
				';
		return $this->query_exec($sql, array($email, $name , $group_id, $id));
	}
	
	// --------------------------------------------------------------------
	/**
	 * delete user
	 *
	 * @author Waldo
	 * @since 2015.02.28
	 *
	 * @param int
	 *
	 * @return bool
	 */
	function deleteUser($id) {
		$sql = 'DELETE from user where id = ?';
		return $this->query_exec($sql, array($id));
	}
}
?>