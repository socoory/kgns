
<div class="content text-center pd_10">
	<div class="col-md-6 basebox center_block pd_20">
		<form id="signup_form" action="<?=URL?>/member/signup_process" method="post" class="form-horizontal">
			<div  class="form-group">
				<label class="col-sm-4 control-label">E-Mail</label>
				<div class="col-sm-8"><input type="text" name="user_email" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8"><input type="text" name="user_name" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Password</label>
				<div class="col-sm-8"><input type="password" name="user_password" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Confirm Password</label>
				<div class="col-sm-8"><input type="password" name="user_password2" class="form-control"></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Group</label>
				<div class="col-sm-8">
					<select name="user_group_id" class="form-control">
						<?php foreach($group as $row) { ?>
						<option value="<?=$row->group_id?>"><?=$row->group_name?></option>
						<?php } ?>
					</select>
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