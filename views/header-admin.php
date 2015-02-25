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
		<div class="pd_tb_10 container-fluid">
            <div class="row">
			    <div class="col-md-2 text-left"><span class="fs_1_8_b va_btm">KGNS</span></div>
			    <div class="col-md-10 text-right">
					<?php if(isset($_SESSION['is_admin'])) { ?>
					<span class="pd_5 fs_0_9">
						<?=$_SESSION['admin_name']?> ( <?=$_SESSION['admin_email']?> )
					</span>
					<a href="<?=URL?>/member/logout">
						<span class="pd_5 fs_0_9">LOGOUT</span>
					</a>
					<?php } else { ?>
					<a href="<?=URL?>/member/login">
						<span class="pd_5 fs_0_9">LOGIN</span>
					</a>
					<?php } ?>
			    </div>
            </div>
		</div>
	</div>

	<div class="container-fluid">
			<div class="row">
				<div id="sidebar" class="col-md-3 pd_15">
					<div class="basebox pd_15">
						<ul class="ul_base">
							<li class="fs_1_0_b">SIDEBAR</li>
							<li><a href="<?=URL?>/gns_admin/user_list">User</a></li>
							<li><a href="<?=URL?>/gns_admin/group_list">Group</a></li>
						</ul>
					</div>
					
					<div class="basebox pd_15">
						<ul class="ul_base">
							<li class="fs_1_0_b">SIDEBAR</li>
							<li>Posts</li>
							<li>Files</li>
							<li>Comments</li>
						</ul>
					</div>
					
					<div class="basebox pd_15">
						<ul class="ul_base">
							<li class="fs_1_0_b">SIDEBAR</li>
							<li>Settings</li>
						</ul>
					</div>
				</div>
				<div class="col-md-9 pd_15">
					<div class="breadcrumbs basebox pd_lr_10 pd_tb_5">HOME > breadcrumbs</div>
