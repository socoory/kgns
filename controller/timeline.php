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
		$posts = $this->timeline_model->getPosts();
		
		require './views/header-timeline.php';
		require './views/timeline.php';
		require './views/footer.php';
	}
	
	function write() {
		require './views/header-no-sidebar.php';
		require './views/write.php';
		require './views/footer-none.php';
	}
	
	
	//*******************************************************//
	//                         post                          //
	//*******************************************************//
	
	function post() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
			
		$content = $_POST['content'];
		$sess    = $this->mapSession();
		if(!isset($sess->user_profile_image)) {
			$sess->user_profile_image = URL.'/images/no-profile.png';
		}
		$info = array($content, $sess->user_id, $sess->user_name, $sess->user_profile_image, $sess->user_group_id);
		
		$res = $this->timeline_model->post($info);
		
		if($res) {
			echo '<script>location.replace("'.URL.'/timeline");</script>';
		}
		else {
			$this->redirect('글 작성 중 오류가 발생하였습니다.', 'timeline', 'write');
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
}
?>
