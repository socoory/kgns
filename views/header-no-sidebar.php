<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<title>KGNS</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="<?=URL?>/js/common.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,600,800' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=URL?>/css/common.css">
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lte IE 7]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script><![endif]-->
</head>
<body>
	<div id="header">
		<div class="pd_10 container-fluid">
            <div class="row">
				<div class="col-md-2 text-left"><span class="fs_1_8_b va_btm">KGNS</span></div>
				<div class="col-md-10 text-right">
					<?php if(isset($_SESSION['is_logged'])) { ?>
					<a href="<?=URL?>/timeline/write"><img src="<?=URL?>/images/write.png" style="height: 22px;"></a>
					<span class="pd_5 fs_0_9">
						<?=$_SESSION['user_name']?> ( <?=$_SESSION['user_email']?> )
					</span>
					<a href="<?=URL?>/member/logout">
						<span class="btn btn-danger btn-xs">LOGOUT</span>
					</a>
					<a href="<?=URL?>/member/edit">
						<span class="btn btn-danger btn-xs">EDIT</span>
					</a>
					<?php } else { ?>
					<a href="<?=URL?>/member/login">
						<span class="btn btn-danger btn-xs">LOGIN</span>
					</a>
					<a href="<?=URL?>/member/signup">
						<span class="btn btn-danger btn-xs">SIGNUP</span>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 pd_10">