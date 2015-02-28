<?php
if (!defined("__KGNS__")) exit;

class Timeline extends Controller {
	function __construct() {
		parent::__construct();
		$this->post_model 		= $this->loadModel('post_model');
		$this->comment_model 	= $this->loadModel('comment_model');
		$this->attach_model 	= $this->loadModel('attach_model');
	}
	
	
	//*********************************************************************//
	//                                page                                 //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * list page
	 * login based
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 */
	public function index() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
		
		$posts = $this->post_model->getPosts();
		
		// get comments and attached files
		foreach($posts as $row) {
			$row->comments 	  = $this->comment_model->getComments($row->post_id, 3);
			$row->attachImage = $this->attach_model->getAttaches($row->post_id, 'i', 3);
			$row->attachFile  = $this->attach_model->getAttaches($row->post_id, 'f', 3);
		}
		
		require './views/header-timeline.php';
		require './views/timeline.php';
		require './views/footer.php';
	}
	
	// ----------------------------------------------------------------------
	/**
	 * write page
	 * login based
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 */
	function write() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
		
		require './views/header-no-sidebar.php';
		require './views/write.php';
		require './views/footer-none.php';
	}
	
	// ----------------------------------------------------------------------
	/**
	 * read page
	 * login based
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param int
	 * 
	 */
	function read($postId=null) {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
		
		if($postId == null) {
			return;
		}
		
		$post = $this->post_model->getPost($postId);
			
		$comments 	 	= $this->comment_model->getComments($postId, 3);
		$attachImage  	= $this->attach_model->getAttaches($postId, 'i');
		$attachFile   	= $this->attach_model->getAttaches($postId, 'f');
		
		if(!$post) {
			require './views/header-no-sidebar.php';
			require './views/404.php';
			require './views/footer-none.php';
			return;
		}
		else {
			$comments 	= $this->comment_model->getComments($postId);
			$posts 		= $this->post_model->getPosts();
			
			require './views/header.php';
			require './views/read.php';
			require './views/timeline_other.php';
			require './views/footer-none.php';
			return;
		}
	}
	
	
	//*********************************************************************//
	//                                post                                 //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * write a post
	 * login based
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 */
	function post() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
			
		$content = strip_tags($_POST['content']);
		$sess    = $this->mapSession();

		// process lunch markup
		if(isset($_POST["lunch"])) {
			$lunchList  = $_POST["lunch"];
			$lunch 		= $lunchList[rand(0, count($lunchList) - 1)];
			
			$content .= '<p class="text-center"><br />
						-------- 식사 메뉴  --------<br />
						후보 메뉴는<br />';
			
			foreach($lunchList as $menu) {
				$content .= '['.$menu.'] ';
			}

			$content .= '<br />였으나, 오늘의 메뉴는!!!<br /><br />
						<strong class="fs_2_4">'.$lunch.'</strong><br /><br />
						이 선택되었습니다.<br />맛있게 드세요 ^___^/</p>';
		}
		
		// create a post record
		$res = $this->post_model->post($content, $_SESSION);
		
		if($res) {
			// insert parent(post) id into attached files
			if(isset($_POST["files"])) {
				$id 		 = $this->post_model->insertId();
				$attachList  = join(',', $_POST["files"]);
				$result 	 = $this->attach_model->insertAttachPostId($attachList, $id);
			}
			
			echo '<script>location.replace("'.URL.'/timeline");</script>';
		}
		else {
			$this->redirect('글 작성 중 오류가 발생하였습니다.', 'timeline', 'write');
		}
	}
	
	// ----------------------------------------------------------------------
	/**
	 * write a comment
	 * login based
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * @param int
	 * 
	 */
	function comment() {
		if(!$this->isLogged())
			header('Location: '.URL.'/member/login');
			
		$sess   = $this->mapSession();
		$post	= $this->mapPost();
		
		$res = $this->comment_model->comment($post->post_id, $post->content, $_SESSION);
		
		if($res) {
			echo '<script>location.replace("'.URL.'/timeline/read/'.$post->post_id.'");</script>';
		}
		else {
			echo 'fail';
		}
	}
	
	
	//*********************************************************************//
	//                                common                               //
	//*********************************************************************//
	
	// ----------------------------------------------------------------------
	/**
	 * return login status
	 * 
	 * @author Benimario
	 * @since 2015.02
	 * 
	 * 
	 */
	function isLogged() {
		return isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : FALSE ;
	}
}
?>
