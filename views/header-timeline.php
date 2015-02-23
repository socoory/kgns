<?php require 'common_header.php'; ?>
	<div id="header">
		<div class="pd_tb_10 container-fluid">
            <div class="row">
			    <div class="col-md-2 text-left">
			    	<a href="<?=URL?>"><span class="fs_1_8_b va_btm">KGNS</span></a>
			    </div>
			    <div class="col-md-10 text-right">
					<?php if(isset($_SESSION['is_logged'])) { ?>
					<a href="<?=URL?>/timeline/write"><img src="<?=URL?>/images/write.png" style="height: 22px;"></a>
					<span class="pd_5 fs_0_9 va_mid">
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

	<div class="container-fluid pd_tb_10">
			<div class="row pd_lr_15">
				<div id="timeline_header" class="pd_20 basebox text-center">
					<h2>KGNS Developers</h2>
				</div>
			</div>
			<div class="row">
				<div id="sidebar" class="col-sm-3 pd_15">
					<div class="basebox pd_lr_15 pd_tb_20">
						<div class="user_info row">
							<div class="col-xs-4">
								<div class="user_profile" style="background-image: url('<?=$_SESSION['user_profile_image']?>');"></div>
							</div>
							<div class="col-xs-8 user_name">
								<span><strong><?=$_SESSION['user_name']?></strong></span><br>
								<a href="<?=URL?>/member/edit">
									<span>Edit</span>
								</a>
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
						</ul>
					</div>
				</div>
				<div class="col-sm-9 pd_15">
