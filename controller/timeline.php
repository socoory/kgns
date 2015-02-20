<?php
if (!defined("__KGNS__")) exit;

class Timeline extends Controller {
	function __construct() {
		parent::__construct();
		$this->timeline_model = $this->loadModel('timeline_model');
	}
	
	
	//*******************************************************//
	//                         page                          //
	//*******************************************************//
	
	public function index() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
		
		$posts 	  = $this->timeline_model->getPosts();
		
		require './views/header-timeline.php';
		require './views/timeline.php';
		require './views/footer.php';
	}
	
	function write() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
		
		require './views/header-no-sidebar.php';
		require './views/write.php';
		require './views/footer-none.php';
	}
	
	function read($post_id=null) {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
		
		if($post_id == null) {
			return;
		}
		
		$post = $this->timeline_model->getPost($post_id);
		$attachImage = $this->timeline_model->getAttaches($post_id, 'i', 3);
		$attachFile  = $this->timeline_model->getAttaches($post_id, 'f', 3);
		
		if(!$post) {
			require './views/header-no-sidebar.php';
			require './views/404.php';
			require './views/footer-none.php';
			return;
		}
		else {
			$comments = $this->timeline_model->getComments($post_id);
			$posts = $this->timeline_model->getPosts();
			
			require './views/header.php';
			require './views/read.php';
			require './views/timeline_other.php';
			require './views/footer-none.php';
			return;
		}
	}
	
	
	//*******************************************************//
	//                         post                          //
	//*******************************************************//
	
	function post() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
			
		$content = strip_tags($_POST['content']);
		$sess    = $this->mapSession();
		
		if(!isset($sess->user_profile_image)) {
			$sess->user_profile_image = URL.'/images/no-profile.png';
		}

		if(isset($_POST["lunch"])) {
			$lunchList  = $_POST["lunch"];
			$lunch = $lunchList[rand(0, count($lunchList) - 1)];
			$content .= '<p class="text-center"><br />-------- 식사 메뉴  --------<br />후보 메뉴는<br />';
			foreach($lunchList as $menu) {
				$content .= '['.$menu.'] ';
			}
			$content .= '<br />였으나, 오늘의 메뉴는!!!<br /><br /><strong class="fs_2_4">'.$lunch.'</strong><br /><br />이 선택되었습니다.<br />맛있게 드세요 ^___^/</p>';
		}

		$info = array($content, $sess->user_id, $sess->user_name,
					  $sess->user_profile_image, $sess->user_group_id);
		$res = $this->timeline_model->post($info);
		
		if($res) {
			if(isset($_POST["files"])) {
				$id 		 = $this->timeline_model->insertId();
				$attachModel = $this->loadModel("attach_model");
				$attachList  = join(',', $_POST["files"]);
				$result 	 = $attachModel->insertAttachPostId($attachList, $id);
			}
			
			echo '<script>location.replace("'.URL.'/timeline");</script>';
		}
		else {
			$this->redirect('글 작성 중 오류가 발생하였습니다.', 'timeline', 'write');
		}
	}
	
	function comment() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
			
		$sess   = $this->mapSession();
		$post	= $this->mapPost();

		$info = array($post->post_id, $post->content, $sess->user_id, $sess->user_name, $sess->user_profile_image);
		
		$res = $this->timeline_model->comment($info);
		
		if($res) {
			echo '<script>location.replace("'.URL.'/timeline/read/'.$post->post_id.'");</script>';
		}
		else {
			echo 'fail';
		}
	}
	
	
	//*******************************************************//
	//                        normal                         //
	//*******************************************************//
	
	function isLogged() {
		return isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : FALSE ;
	}

	function mapSession() {
		$object = new stdClass();
		
		foreach($_SESSION as $key => $val) {
			$object->$key = $val;
		}
		
		return $object;
	}

	function mapPost() {
		$object = new stdClass();
		
		foreach($_POST as $key => $val) {
			$object->$key = $val;
		}
		
		return $object;
	}
}
?>
