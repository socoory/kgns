<?php

Class Member extends Controller {
	function __construct() {
		parent::__construct();
		$this->user_model = $this->loadModel('user_model');
		$this->activity_model = $this->loadModel('activity_model');
	}
	
	//*********************************************************************//
	//                                page                                 //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * signup page
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function signup() {
		$groups_model = $this->loadModel('groups_model');
		$group = $groups_model->getGroupInfo();
		require './views/header-no-sidebar.php';
		require './views/signup.php';
		require './views/footer.php';	
	}
	
	// ----------------------------------------------------------------------
	/**
	 * login page
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function login() {
		require './views/header-no-sidebar.php';
		require './views/login.php';
		require './views/footer.php';
	}
	
	// ----------------------------------------------------------------------
	/**
	 * edit information page
	 * login based
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function edit() {
		$groups_model = $this->loadModel('groups_model');
		$group = $groups_model->getGroupInfo();
		require './views/header-no-sidebar.php';
		require './views/edit.php';
		require './views/footer.php';
	}
	
	//*********************************************************************//
	//                              sign up                                //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * Sign up 
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function signup_process() {
		$options 		= array('cost' => 11);
		$email 			= $_POST['user_email'];
		$checked_email 	= $this->user_model->getUserByEmail($email); 
		
		if(!empty($checked_email)) {	//check overlapping e-mail
			echo '<script>
			alert("중복된 이메일이 있습니다.");
			location.replace("'.URL.'/member/signup");
			</script>';
		}
		else { 
			$name 			= $_POST['user_name'];
			$password	 	= password_hash($_POST['user_password'], PASSWORD_BCRYPT, $options);	//bcrypt for hashing password
			$group_id		= $_POST['user_group_id'];
			$profile_image	= 'images/no-profile.png';
					
			$res  = $this->user_model->createUser($email, $name, $password, $group_id, $profile_image);
			
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
	}
	
	//*********************************************************************//
	//                                Login                                //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * Login 
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function login_process() {
		$email		= $_POST['user_email'];
		$password	= $_POST['user_password'];
		
		$res 		 = $this->user_model->getUserByEmail($email);
		
		if($res == false) {
			echo '<script>
			alert("Login Fail");
			location.replace("'.URL.'/member/login");
			</script>';
		}
		else {
			$activity_id = $this->activity_model->getLatestActivity($res->id)->activity_id;	//Get user's Latest Activity ID
			
			if(password_verify($password, $res->password)) {			//check password's verify
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				    $ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
				    $ip = $_SERVER['REMOTE_ADDR'];
				}
				$_SESSION['user_ip']			= $ip;					
				$_SESSION['is_logged'] 			= true;
				$_SESSION['user_id'] 			= $res->id;
				$_SESSION['user_name'] 			= $res->name;
				$_SESSION['user_email'] 		= $res->email;
				$_SESSION['user_group_id'] 		= $res->group_id;
				$_SESSION['user_profile_image']	= $res->profile_image;
				setCookie("latest_activity_id", $activity_id, 0, "/");
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
	
	//*********************************************************************//
	//                                 Edit                                //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * Edit user's information 
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function edit_process() {
		
		require 'libs/functions.php';
		
		$email_info = $_POST['user_email'];
		$checked_email = $this->user_model->getUserByEmail($email_info);
		
		if((empty($checked_email) == FALSE) && ($_SESSION['user_email'] != $_POST['user_email'])) { //check overlapping e-mail
			$this->redirect("중복된 이메일이 있습니다.", "member", "edit");
			return;
		}
		else {
			$temp_res = $this->user_model->getUserByEmail($email_info); 
			$old_password = $_POST['user_old_password'];
			
			if(password_verify($old_password, $temp_res->password) == FALSE) { //check old password
				$this->redirect("이전 패스워드가 맞지 않습니다.", "member", "edit");
				return;
			}
			else {
				if(isset($_POST['check_delete_image'])) {
					$uploadfile = URL.'images/no-profile.png';
				}
				else {
					$user_profile_image = $_FILES['user_profile_image'];
					$fileType 			= explode('/', $user_profile_image['type']);
					$fileName 			= time().$user_profile_image['name'];
					if($user_profile_image['name'] == null) {
						$uploadfile = $_SESSION['user_profile_image'];
					}
					else {
						if($fileType[0] != 'image') {	// check that file type is image
							$this->redirect("이미지 파일이 아닙니다.", "member", "edit");
							return;
						}
						else {
							$uploaddir = 'upload/profile/'.$_SESSION['user_id'];				
							if(file_exists($uploaddir) == false) {
								mkdir("$uploaddir", 0777); 
							}
							$fileName = sha1($fileName).'.'.$fileType[1];
							$uploadfile = $uploaddir.'/'.$fileName;
							if(move_uploaded_file($user_profile_image['tmp_name'], $uploadfile))
							{
								$thumb = createThumb($uploaddir, $fileName, 100, 100);
								$uploadfile = $thumb;
								// var_dump($thumb);
								// return;
							}
						}
					}
				}

				$options 		= array('cost' => 11);
				$email      	= $_POST['user_email'];
				$name     		= $_POST['user_name'];
				
				if($_POST['user_new_password'] == "") {
					$password = $temp_res->password;
				}
				else {
					$password = password_hash($_POST['user_new_password'], PASSWORD_BCRYPT, $options);
				}
				
				$group_id		= $_POST['user_group_id'];
				$user_id 		= $_SESSION['user_id'];
				$profile_image	= $uploadfile;
				$info = array($email, $name, $password, $group_id, $profile_image, $user_id);
				$res = $this->user_model->updateUserInfo($info);
				
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
	}
	
	//*********************************************************************//
	//                                Logout                               //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * Logout
	 * 
	 * @author waldo
	 * @since 2015.02
	 * 
	 */
	function logout() {
		session_destroy();
		setcookie('latest_activity_id');
		echo '<script>
			alert("Logout Success!");
			location.replace("'.URL.'");
			</script>';
	}
	//*********************************************************************//
	//                               Activity                              //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * Get Activity row
	 * 
	 * @author waldo
	 * @since 2015.03
	 * 
	 * @param int
	 * 
	 */
	function activity($activity_id) {
		$res = $this->activity_model->getActivity($_SESSION['user_id'], $activity_id);
		$activity_array = array();
		
		for($i = 0; $i < count($res); $i++) {
			$user_name = $this->user_model->getUserById($res[$i]->source_id)->name;
			if($res[$i]->activity_type == 1)
				$message = "글을 작성하였습니다.";
			else if($res[$i]->activity_type == 2)
				$message = "댓글을 달았습니다.";
			else if($res[$i]->activity_type == 3)
				$message = "좋아요를 눌렀습니다.";
			else if($res[$i]->activity_type == 4)
				$message = "싫어요를 눌렀습니다.";
			
			array_push($activity_array, array("activity_id" => $res[$i]->activity_id, "activity_type" => $message,
					   "user_name" => $user_name, "post_id" => $res[$i]->parent_id));	
		}
		
		if($res) {
			$json = json_encode($activity_array, JSON_UNESCAPED_UNICODE);
			echo $json;
		}
			else {
			echo $activity_id;
		}
	}
}
?>
