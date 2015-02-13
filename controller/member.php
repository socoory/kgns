<?php

Class Member extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function signup() {
		$model = $this->loadModel('member_model');
		$group = $model->loadGroupInfo();
		require './views/header-no-sidebar.php';
		require './views/signup.php';
		require './views/footer.php';	
	}
	
	function login() {
		require './views/header-no-sidebar.php';
		require './views/login.php';
		require './views/footer.php';
	}
	
	function edit() {
		$model = $this->loadModel('member_model');
		$group = $model->loadGroupInfo();
		require './views/header-no-sidebar.php';
		require './views/edit.php';
		require './views/footer.php';
	}
	
	function signup_process() {
		$options = array('cost' => 11);
		$model 			= $this->loadModel('member_model');
		$email 			= $_POST['user_email'];
		$name 			= $_POST['user_name'];
		$password	 	= password_hash($_POST['user_password'], PASSWORD_BCRYPT, $options);
		$group_id		= $_POST['user_group_id'];
		$profile_image	= './images/no-profile.png';
		
		$info = array($email, $name, $password, $group_id, $profile_image);
		
		$res  = $model->regist($info);
		
		if($res) {
			echo '<script>
			alert("Sign Up Success!");
			location.replace("'.URL.'");
			</script>';
		}
		else {
			echo '<script>
			alert("Sign Up Fail!");
			location.replace("'.URL.'/member/signup");
			</script>';	
		}
	}
	
	function login_process() {
		$model		= $this->loadModel('member_model');
		$email		= $_POST['user_email'];
		$password	= $_POST['user_password'];
		
		$info = array($email);
		$res = $model->loadUserInfo($info);
		
		if($res == false) {
			echo '<script>
			alert("Login Fail");
			location.replace("'.URL.'/member/login");
			</script>';
		}
		else {
			if(password_verify($password, $res->password)) {
				$_SESSION['is_logged'] 			= true;
				$_SESSION['user_id'] 			= $res->id;
				$_SESSION['user_name'] 			= $res->name;
				$_SESSION['user_email'] 		= $res->email;
				$_SESSION['user_group_id'] 		= $res->group_id;
				$_SESSION['user_profile_image']	= $res->profile_image;
				header('Location: '. URL);
			}
			else {
				echo '<script>
				alert("Login Fail");
				location.replace("'.URL.'/member/login");
				</script>';
			}
		}
	}
	
	function edit_process() {
		$model = $this->loadModel('member_model');
		
		$info = array($_SESSION['user_email']);
		$temp_res = $model->loadUserInfo($info);
		$old_password = $_POST['user_old_password'];
		
		if(password_verify($old_password, $temp_res->password) == FALSE) {
			echo '<script>
			alert("Old password do not match!");
			location.replace("'.URL.'/member/edit");
			</script>';
		}
		else {
			if($_FILES['user_profile_image']['size'] == 0)
			{
				$uploadfile = $_SESSION['user_profile_image'];
			}
			else{
				$uploaddir = './upload/profile/'.$_SESSION['user_id'].'/';
				if(file_exists($uploaddir) == false)
				{
					mkdir("$uploaddir",0777); 
				}
				$uploadfile = $uploaddir . basename($_FILES['user_profile_image']['name']);
				move_uploaded_file($_FILES['user_profile_image']['tmp_name'], $uploadfile);
			}
			$options 		= array('cost' => 11);
			$email      	= $_POST['user_email'];
			$name     		= $_POST['user_name'];
			
			if($_POST['user_new_password'] == "") {
				$password = $temp_res->password;
			}
			else {
				$password 		= password_hash($_POST['user_new_password'], PASSWORD_BCRYPT, $options);
			}
			
			$group_id		= $_POST['user_group_id'];
			$user_id 		= $_SESSION['user_id'];
			$profile_image	= $uploadfile;
			$info = array($email, $name, $password, $group_id, $profile_image, $user_id);
			$res = $model->edit($info);
			
			if($res == TRUE) {
				$_SESSION['user_id'] 			= $res->id;
				$_SESSION['is_logged'] 			= true;
				$_SESSION['user_name'] 			= $res->name;
				$_SESSION['user_email'] 		= $res->email;
				$_SESSION['user_group_id'] 		= $res->group_id;
				$_SESSION['user_profile_image']	= $res->profile_image;
				header('Location: '. URL);
			}
			else {
				echo '<script>
				alert("Edit Fail!");
				location.replace("'.URL.'/member/edit");
				</script>';	
			}
		}
	}
	
	function logout() {
		session_destroy();
		echo '<script>
			alert("Logout Success!");
			location.replace("'.URL.'");
			</script>';
	}
}
?>