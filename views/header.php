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
	<?php if(!isset($_SESSION['is_logged'])) echo '<script>location.replace("'.URL.'/member/login")</script>'; ?>
</head>
<body>
	<div id="header">
		<div class="pd_10 container-fluid">
            <div class="row">
			    <div class="col-md-2 text-left"><span class="fs_1_8_b va_btm">KGNS</span></div>
			    <div class="col-md-10 text-right">
					<?php if(isset($_SESSION['is_logged'])) { ?>
					<span class="pd_5 fs_1_0 va_mid">
						<?=$_SESSION['user_name']?> ( <?=$_SESSION['user_email']?> )
					</span>
					<a href="<?=URL?>/member/logout">
						<span class="btn btn-danger btn-xs">LOGOUT</span>
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
				<div id="sidebar" class="col-md-3 pd_10">
					<div class="basebox pd_lr_15 pd_tb_20">
						<div class="user_info row">
							<div class="col-xs-4">
								<div class="user_profile" style="background-image: url('<?=URL?>/images/no-profile.png');"></div>
							</div>
							<div class="col-xs-8 user_name">
								<span><strong><?=$_SESSION['user_name']?></strong></span><br>
								<span>Edit</span>
								</div>
						</div>
					</div>
					
					<div class="basebox pd_15">
						<ul class="ul_base">
							<li class="fs_1_0_b">SIDEBAR</li>
							<li>Menu 01</li>
							<li>Menu 02</li>
							<li>Application</li>
							<li>Dashboard</li>
							<li>Settings</li>
							<li>row_03</li>
							<li>row_01</li>
							<li>row_02</li>
							<li>row_03</li>
						</ul>
					</div>
					
					<ul class="list-group">
						<li class="list-group-item">ROW 01 menu MENU</li>
						<li class="list-group-item">ROW 02 Test</li>
						<li class="list-group-item">ROW 03</li>
						<li class="list-group-item">ROW 04</li>
						<li class="list-group-item">ROW 05</li>
					</ul>
				</div>
				<div class="col-md-9 pd_10">
					<div class="breadcrumbs basebox pd_lr_10 pd_tb_5">HOME > breadcrumbs</div>
