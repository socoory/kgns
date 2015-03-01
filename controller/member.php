<?php

Class Member extends Controller {
	function __construct() {
		parent::__construct();
		$this->member_model = $this->loadModel('member_model');
	}
	
	function signup() {
		$group = $this->member_model->loadGroupInfo();
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
		$group = $this->member_model->loadGroupInfo();
		require './views/header-no-sidebar.php';
		require './views/edit.php';
		require './views/footer.php';
	}
	
	function signup_process() {
		$options = array('cost' => 11);
		$email 			= $_POST['user_email'];
		$email_info = array($email);
		$checked_email = $this->member_model->loadEmailInfo($email_info);
		if(!empty($checked_email)) {
			echo '<script>
			alert("중복된 이메일이 있습니다.");
			location.replace("'.URL.'/member/signup");
			</script>';
		}
		else { 
			$name 			= $_POST['user_name'];
			$password	 	= password_hash($_POST['user_password'], PASSWORD_BCRYPT, $options);
			$group_id		= $_POST['user_group_id'];
			$profile_image	= URL.'/images/no-profile.png';
			
			$info = array($email, $name, $password, $group_id, $profile_image);
			
			$res  = $this->member_model->regist($info);
			
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
	
	function login_process() {
		$email		= $_POST['user_email'];
		$password	= $_POST['user_password'];
		
		$info = array($email);
		$res = $this->member_model->loadUserInfo($info);
		$activity_id = $this->member_model->getLatestActivity()->activity_id;

		if($res == false) {
			echo '<script>
			alert("Login Fail");
			location.replace("'.URL.'/member/login");
			</script>';
		}
		else {
			if(password_verify($password, $res->password)) {
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
	
	function edit_process() {
		$email_info = array($_POST['user_email']);
		$checked_email = $this->member_model->loadEmailInfo($email_info);
		
		if((empty($checked_email) == FALSE) && ($_SESSION['user_email'] != $_POST['user_email'])) {
			$this->redirect("중복된 이메일이 있습니다.", "member", "edit");
			return;
		}
		else {
			$temp_res = $this->member_model->loadUserInfo($email_info);
			$old_password = $_POST['user_old_password'];
			
			if(password_verify($old_password, $temp_res->password) == FALSE) {
				$this->redirect("이전 패스워드가 맞지 않습니다.", "member", "edit");
				return;
			}
			else {
				if(isset($_POST['check_delete_image'])) {
					$uploadfile = URL.'/images/no-profile.png';
				}
				else {
					if($_FILES['user_profile_image']['name'] == null) {
						$uploadfile = $_SESSION['user_profile_image'];
					}
					else {
						if(strpos($_FILES['user_profile_image']['type'], 'image') === false) {
							$this->redirect("이미지 파일이 아닙니다.", "member", "edit");
							return;
						}
						else {
							$uploaddir = './upload/profile/'.$_SESSION['user_id'].'/';				
							if(file_exists($uploaddir) == false) {
								mkdir("$uploaddir", 0777); 
							}
							$uploadfile = $uploaddir . $_FILES['user_profile_image']['name'];
							if(move_uploaded_file($_FILES['user_profile_image']['tmp_name'], $uploadfile))
							{
								$thumb = $uploaddir.'/thumb_'. $_FILES['user_profile_image']['name'];
								
								if($this->make_thumbnail($uploadfile, 100, 100, $thumb)) {
									$uploadfile = URL.'/upload/profile/'.$_SESSION['user_id'].'/'.'thumb_'. $_FILES['user_profile_image']['name'];
								}
								else {
									$thumb = $uploaddir;
								}
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
				$res = $this->member_model->edit($info);
				
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
	
	function make_thumbnail($source_file, $_width, $_height, $object_file) {
	    list($img_width,$img_height, $type) = getimagesize($source_file);
	    
	    if ($type == 1) $img_sour = imagecreatefromgif($source_file);
	    else if ($type == 2) $img_sour = imagecreatefromjpeg($source_file);
	    else if ($type == 3) $img_sour = imagecreatefrompng($source_file);
	    else if ($type==15) $img_sour = imagecreatefromwbmp($source_file);
	    else return false;
	    
	    if ($img_width > $img_height) {
	        $width = round($_height * $img_width / $img_height);
	        $height = $_height;
	    } 
	    else {
	        $width = $_width;
	        $height = round($_width * $img_height / $img_width);
	    }
		
	    if ($width < $_width) {
	        $width = round(($height + $_width - $width)* $img_width / $img_height);
	        $height = round(($width + $_width - $width)* $img_height / $img_width);
	    } 
	    else if ($height < $_height) {
	        $height = round(($width + $_height - $height) * $img_height / $img_width);
	        $width = round(($height + $_height - $height) * $img_width / $img_height);
	    }
	    $x_last = round(($width - $_width) / 2);
	    $y_last = round(($height - $_height) / 2);
	    
	    if ($img_width < $_width || $img_height < $_height) {
	        $img_last = imagecreatetruecolor($_width, $_height); 
	        $x_last = round(($_width - $img_width) / 2);
	        $y_last = round(($_height - $img_height) / 2);
			imagecopy($img_last, $img_sour, $x_last, $y_last, 0, 0, $width,$height);
	        imagedestroy($img_sour);
	        $white = imagecolorallocate($img_last, 255, 255, 255);
	        imagefill($img_last, 0, 0, $white);
	    } 
	    else {
	        $img_dest = imagecreatetruecolor($width, $height); 
	        imagecopyresampled($img_dest, $img_sour, 0, 0, 0, 0, $width, $height, $img_width, $img_height); 
	        $img_last = imagecreatetruecolor($_width, $_height); 
	        imagecopy($img_last, $img_dest, 0, 0, $x_last, $y_last, $width, $height);
	        imagedestroy($img_dest);
	    }
	    if ($object_file) {
	        if ($type == 1) imagegif($img_last, $object_file, 100);
	        else if ($type == 2) imagejpeg($img_last, $object_file, 100);
	        else if ($type == 3) {
	        	imagealphablending($img_last, false);
				imagesavealpha($img_last, true);	
	        	imagepng($img_last, $object_file);
			}
	        else if ($type == 15) imagebmp($img_last, $object_file, 100);
	    } else {
	        if ($type == 1) imagegif($img_last);
	        else if ($type == 2) imagejpeg($img_last);
	        else if ($type == 3) {
	        	imagealphablending($img_last, false);
				imagesavealpha($img_last, true);	
	        	imagepng($img_last);
			}
	        else if ($type == 15) imagebmp($img_last);
	    }
	    imagedestroy($img_last);
	    return true;
	}
	
	function logout() {
		session_destroy();
		setcookie('latest_activity_id');
		echo '<script>
			alert("Logout Success!");
			location.replace("'.URL.'");
			</script>';
	}
	
	function activity($activity_id) {
		$this->timeline_model = $this->loadModel('timeline_model');
		$activity_info = array($_SESSION['user_id'], $activity_id);
		$res = $this->timeline_model->getActivity($activity_info);
		$activity_array = array();
		
		for($i = 0; $i < count($res); $i++)
		{
			$user_name = $this->member_model->getUserName(array($res[$i]->source_id));
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
		
		if($res){
			$json = json_encode($activity_array, JSON_UNESCAPED_UNICODE);
			echo $json;
			}
			else {
			echo $activity_id;
		}
	}
}
?>
