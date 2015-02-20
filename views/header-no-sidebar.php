<?php require 'common_header.php' ?>
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

	<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 pd_15">