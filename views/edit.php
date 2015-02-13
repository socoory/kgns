
<div class="content text-center pd_10">
	<div class="col-md-6 basebox center_block pd_20">
		<form enctype="multipart/form-data" id="signup_form" action="<?=URL?>/member/edit_process" method="post" class="form-horizontal">
			<div  class="form-group">
				<label class="col-sm-4 control-label">E-Mail</label>
				<div class="col-sm-8"><input type="text" name="user_email" value = <?php echo $_SESSION['user_email']?> class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8"><input type="text" name="user_name" value = <?php echo $_SESSION['user_name']?> class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Old Password</label>
				<div class="col-sm-8"><input type="password" name="user_old_password" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">New Password</label>
				<div class="col-sm-8"><input type="password" name="user_new_password" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Confirm New Password</label>
				<div class="col-sm-8"><input type="password" name="user_new_password2" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Group</label>
				<div class="col-sm-8">
					<select name="user_group_id" class="form-control">
						<?php foreach($group as $row) {
							if($row->group_id == $_SESSION['user_group_id']) { ?>
								<option value="<?=$row->group_id?>" selected="selected"><?=$row->group_name?></option>
						<?php } else { ?>
								<option value="<?=$row->group_id?> "><?=$row->group_name?></option>
						<?php }
						 } ?>
					</select>
				</div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Profile Image</label>
				<div class="col-sm-8">
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
					<input type="file" name="user_profile_image" accept="image/*" class="form-control">
				</div>
			</div>
			<div class="form-group" style="margin-bottom: 0">				
				<div class="col-md-12 text-right">
					<button type="submit" class="btn btn-danger">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>