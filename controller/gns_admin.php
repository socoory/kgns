<?php

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
				
				//location.replace("'.URL.'/gns_admin/edit_user");
			}
			else {
				echo '<script>
				alert("Login Fail");
				location.replace("'.URL.'/member/login");
				</script>';
			}
		}
	}
	
	function user_list() {
		$model = $this->loadModel('member_model');
		$users = $model->getUsers();
		
		require './views/header-admin.php';
		require './views/user-list.php';
		require './views/footer.php';	
		
	}
	
	function edit_user($id) {
		$model = $this->loadModel('member_model');
		$user = $model->getUserById($id);
		$group = $model->loadGroupInfo();
		
		require './views/header-admin.php';
		require './views/edit-user-admin.php';
		require './views/footer.php';
	}
	
	function edit_user_process() {
		$model = $this->loadModel('admin_model');
		
		$email = $_POST['user_email'];
		$name = $_POST['user_name'];
		$group_id = $_POST['user_group_id'];
		
		$info = array($email, $name , $group_id, $email);
		
		$res = $model->edit_user($info);
		
		if($res) {
			echo '<script>location.replace("'.URL.'/gns_admin/user_list");</script>';
		}
		else {
			echo '<script>alert("edit fail!"); location.replace("'.URL.'/gns_admin/user_list");</script>';
		}
				
	}
	
}

?>