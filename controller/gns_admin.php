<?php
if (!defined("__KGNS__")) exit;

Class Gns_admin extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		require './views/header-no-sidebar.php';
		require './views/login-admin.php';
		require './views/footer.php';
	}
	
	function login_process() {
		$model = $this->loadModel('admin_model');
		$email		= $_POST['user_email'];
		$password	= $_POST['user_password'];
		
		$info = array($email);
		$res = $model->loadAdminInfo($info);
		
		if($res == false) {
			echo '<script>
			alert("Login Fail");
			location.replace("'.URL.'/gns_admin/index");
			</script>';
		}
		else {
			if(password_verify($password, $res->password)) {
				$_SESSION['is_admin'] 		= true;
				$_SESSION['admin_name'] 	= $res->name;
				$_SESSION['admin_email'] 	= $res->email;
				
				header('Location: '. URL.'/gns_admin/user_list');
			}
			else {
				echo '<script>
				alert("Login Fail");
				location.replace("'.URL.'/gns_admin");
				</script>';
			}
		}
	}
	
	function user_list($page=1) {
		if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) {
			$member_model 	= $this->loadModel('member_model');
			$admin_model 	= $this->loadModel('admin_model');
			$limit 			= 10;
			$startPage 		= 1;
			$endPage 		= 0;
			$group_id 		= 0;
			
			if(isset($_GET['gid'])) {
				$_POST['group_id'] = $_GET['gid'];
			}
			
			if(!isset($_POST['group_id']) || $_POST['group_id'] == 0) {
				$totalPage = $admin_model->getTotalPage('user');
			}
			else {
				$group_id = $_POST['group_id'];
				$totalPage = $admin_model->getTotalPage('user', 'group_id = '.$group_id);
			}
			
			// calculate page numbers
			if(($page > 2) && ($page < $totalPage -2)) {
				$startPage = $page - 2;
				$endPage = $page + 2;					
			}
			else if($page <= 2) {
				$startPage = 1;
				$endPage = $totalPage > 5 ? 5 : $totalPage;
			}
			else {
				if ($totalPage - 4 == 0)
					$startPage = 1;
				else
					$startPage = $totalPage - 4;
				$endPage = $totalPage;
			}
				
			$info = array('start' 	=> ($page*10 - 10),
						  'end' 	=> $limit);
						  
			// select user query
			if($group_id == 0) {
				$users = $admin_model->getUsersByLimit($info);				
			}
			else {
				$users = $admin_model->getUsersByLimit($info, $group_id);
			}
			
			// $%@^@%
			$group = $member_model->loadGroupInfo();
			$currPage = $page;
			
			require './views/header-admin.php';
			require './views/user-list.php';
			require './views/footer.php';
			
		}
		else {
			$this->redirect('404 Not Found Error', 'gns_admin', '');
		}		
	}
	
	function edit_user($id) {
		if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) {
			$model = $this->loadModel('member_model');
			$user = $model->getUserById($id);
			$group = $model->loadGroupInfo();
			
			require './views/header-admin.php';
			require './views/edit-user-admin.php';
			require './views/footer.php';
		}
		else {
			$this->redirect('404 Not Found Error', 'gns_admin', '');
		}
	}
	
	function edit_user_process() {
		$model = $this->loadModel('admin_model');
		
		$id = $_POST['user_id'];
		$email = $_POST['user_email'];
		$name = $_POST['user_name'];
		$group_id = $_POST['user_group_id'];
		
		$info = array($email, $name , $group_id, $id);
		
		$res = $model->edit_user($info);
		
		if($res) {
			echo '<script>location.replace("'.URL.'/gns_admin/user_list");</script>';
		}
		else {
			echo '<script>alert("edit fail!"); location.replace("'.URL.'/gns_admin/user_list");</script>';
		}
				
	}
	
	function delete_user($id=null) {
		if($id == null) {
			return;
		}
		
		if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) {						
			$model = $this->loadModel('admin_model');
			$res = $model->delete_user(array($id));
			
			if($res) {
				$this->redirect('delete success', '/gns_admin/user_list', '');
			}
			else {
				$this->redirect('delete fail', '/gns_admin/user_list', '');
			}
		}
		else {
			$this->redirect('404 Not Found Error', 'gns_admin', '');
		}		
	}
		
	function group_list() {
		if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) {
			$model = $this->loadModel('member_model');
			$groups = $model->loadGroupInfo();
			
			require './views/header-admin.php';
			require './views/admin-group-list.php';
			require './views/footer.php';
		}
		else {
			$this->redirect('404 Not Found Error', 'gns_admin', '');
		}
	}

	function edit_group($g_id) {
		if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) {
			$member_model = $this->loadModel('member_model');
			$group = $member_model->loadGroupInfo();
			
			require './views/header-admin.php';
			require './views/edit-user-admin.php';
			require './views/footer.php';
		}
		else {
			$this->redirect('404 Not Found Error', 'gns_admin', '');
		}
	}
	
	function delete_group() {
		
	}
}

?>