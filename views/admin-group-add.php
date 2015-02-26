<div class="basebox pd_lr_10 pd_tb_5">
	<div class="col-md-6 center_block pd_10">							
		<form id="edit_form" action="<?=URL?>/gns_admin/add_group_process" method="post" class="form-horizontal">
			<!-- <input type="hidden" name="group_id" value=<?php echo($group->group_id) ?> />
			<div  class="form-group">
				<fieldset disabled>
					<label class="col-sm-4 control-label">Group ID</label>
					<div class="col-sm-8"><input type="text" name="group_id" class="form-control" value=<?php echo($group->group_id) ?>></div>
				</fieldset>
			</div> -->
			<div  class="form-group">
				<label class="col-sm-4 control-label">Group Name</label>
				<div class="col-sm-8"><input type="text" name="group_name" class="form-control" placeholder="Group Name"></div>
			</div>			
			<div class="form-group" style="margin-bottom: 0">				
				<div class="col-md-12 text-right">
					<button type="submit" class="btn btn-danger">Submit</button>
				</div>
			</div>
		</form>						
	</div>
</div>