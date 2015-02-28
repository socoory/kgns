<div class="basebox pd_lr_10 pd_tb_5">
	<form id="group-select" action="<?=URL?>/gns_admin/user_list/" method="post" class="form-inline pd_5">
		<div class="form-group">
			<label class="control-label">Group</label>
			<select name="group_id" class="form-control fs_1_0" style="height:25px; padding: 2px 6px" onChange="this.form.submit()">
				<option value="0">All</option>
				<?php if(isset($group_id)) { ?>				
					<?php foreach($group as $row) { ?>
					<option value="<?=$row->group_id?>" <?=($group_id==$row->group_id) ? "selected" : ""?>><?=$row->group_name?></option>
					<?php } ?>				
				<?php } else { ?>
					<?php foreach($group as $row) { ?>
					<option value="<?=$row->group_id?>"?><?=$row->group_name?></option>
					<?php } ?>
				<?php } ?>				
			</select>
		</div>
	</form>
	<div>
		<table class="table table-hover">
			<tr>
				<th>ID</th>
				<th>E-Mail</th>
				<th>Name</th>
				<th>Registered Date</th>
				<th>Group</th>
				<th>Edit</th>
			</tr>
			<?php foreach($users as $user) { ?>
			<tr>
				<td style="width:5%"><?=$user->id?></td>
				<td style="width:30%"><?=$user->email?></td>
				<td style="width:15%"><?=$user->name?></td>
				<td><?=date('Y-m-d', strtotime($user->regdate))?></td>
				<td><?=$user->group_name?></td>
				<td><a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/edit_user/<?=$user->id?>" role="button">Edit</a>
					<a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/delete_user/<?=$user->id?>" role="button">Delete</a>
				</td>				
			</tr>
			<?php } ?>
		</table>
	</div>
	<div class="bs-component center_wrap pd_tb_5">
		<div class="center_innerWrap">
	    	<div class="center_content btn-toolbar">
	      		<div class="btn-group">
	          		<a href="#" class="btn btn-default btn-sm">&laquo;</a>
	        	</div>  
		        <div class="btn-group">
		        	<?php for($i = $startPage; $i <= $endPage; $i++) { ?>
		          	<a href="<?=URL?>/gns_admin/user_list/<?=$i?>?gid=<?=$group_id?>" class="btn btn-default btn-sm <?=($currPage==$i)? "active" : ""?>"><?=$i?></a>
		          	<?php } ?>
		        </div>
		        <div class="btn-group">
		          	<a href="#" class="btn btn-default btn-sm">&raquo;</a>
		        </div>
	      	</div>
		</div>
     </div>
</div>


