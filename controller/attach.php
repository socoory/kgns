<?php

class Attach extends Controller {
	function __construct() {
		parent::__construct();
		$this->model = $this->loadModel('attach_model');
	}
	
	function index() {
		if(!$this->isLogged()) {
			exit();
		}
		
		require 'libs/functions.php';
		
		$session  	= $this->mapSession();	
		$attach   	= $_FILES['attach'];
		$fileType 	= explode('/', $attach['type']);
		$fileName 	= time().$attach['name'];
		$type 	  	= null;    // 'i': image, 'f': non-image
		$uploadDir 	= 'upload/attach/'.$session->user_id;
		
		if($fileType[0] == 'image') {
			$fileName = sha1($fileName).'.'.$fileType[1];
			$type = 'i';
		}
		else {
			// for split file extension
			$fileExt = explode('.', $attach['name']);
			$type = 'f';
			
			// file extension exist : ['index', 'html']
			if(count($fileExt) > 1) {
				$fileExt = $fileExt[count($fileExt) - 1];
				$fileName = sha1(time().$attach['name']).'.'.$fileExt;
			}
			// file extension not exist
			else {
				$fileName = sha1(time().$attach['name']);
			}
		}
		
		if(!file_exists($uploadDir)) {
			if(!mkdir($uploadDir)) {
				echo FALSE;
				return;
			}
		}
		
		$fileUrl = $uploadDir.'/'.$fileName;
		if(!move_uploaded_file($attach['tmp_name'], $fileUrl)) {
			echo FALSE;
			return;
		}
		
		$res = $this->model->attach(array($session->user_id, $fileUrl, $type, $attach['name']));
		$thumb = createThumb($uploadDir, $fileName, 100, 100);
		
		if($res) {
			$obj = new stdClass();
			$obj->fileUrl 	= $thumb;
			$obj->fileName 	= $attach['name'];
			$obj->fileNo 	= $this->model->insertId();
			echo json_encode($obj);
		}
		else {
			echo FALSE;
		}
		
		return;
	}
	
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