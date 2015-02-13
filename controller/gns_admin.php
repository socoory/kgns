<?php

Class Gns_admin extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		require './views/header-no-sidebar.php';
		require './views/admin-login.php';
		require './views/footer.php';
	}
	
	function login_process() {
		$model = $this->loadModel('admin_model');
	}
	
}

?>