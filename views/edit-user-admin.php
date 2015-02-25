<div class="basebox pd_lr_10 pd_tb_5">
	<div class="col-md-6 center_block pd_10">							
		<form id="edit_form" action="<?=URL?>/gns_admin/edit_user_process" method="post" class="form-horizontal">
			<input type="hidden" name="user_id" value="<?=$user->id?>" />
			<div  class="form-group">
				<label class="col-sm-4 control-label">E-Mail</label>
				<div class="col-sm-8"><input type="text" name="user_email" class="form-control" value=<?php echo($user->email) ?>></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8"><input type="text" name="user_name" class="form-control" value=<?php echo($user->name) ?>></div>
			</div>
			<div  class="form-group">
				<label class="col-sm-4 control-label">Group</label>
				<div class="col-sm-8">
					<select name="user_group_id" class="form-control">
						<?php foreach($group as $row) { ?>
						<option value="<?=$row->group_id?>" <?=($user->group_id==$row->group_id) ? "selected" : ""?>>
							<?=$row->group_name?>
						</option>
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