<?php

Class Test extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		require './views/header.php';
		require './views/signup.php';
		require './views/footer.php';
	}
}

?>