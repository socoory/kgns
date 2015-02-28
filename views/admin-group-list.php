<div class="basebox pd_lr_10 pd_tb_5">
	<div class="pd_tb_10">
		<table class="table table-hover">
			<tr>
				<th>Number</th>
				<th>Group Name</th>
				<th>Total</th>
				<th>Edit</th>
			</tr>
			<?php foreach ($groups as $key => $group) { ?>
			<tr>
				<td style="width:20%"><?=$key + 1?></td>
				<td style="width:40%"><?=$group->group_name?></td>
				<td style="width:20%"><?=$group->cnt?></td>
				<td><a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/edit_group/<?=$group->group_id?>" role="button">Edit</a>
					<a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/delete_group/<?=$group->group_id?>" role="button">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<div class="text-center form-group">
		<a class="btn btn-default btn-sm" href="<?=URL?>/gns_admin/add_group" role="button">Add new group</a>
	</div>
</div>