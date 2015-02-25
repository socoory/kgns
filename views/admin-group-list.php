<div class="basebox pd_lr_10 pd_tb_5">
	<div>
		<table class="table table-hover">
			<tr>
				<th>Group ID</th>
				<th>Group Name</th>
				<th>Total</th>
				<th>Edit</th>
			</tr>
			<?php foreach ($groups as $group) { ?>
			<tr>
				<td style="width:20%"><?=$group->group_id?></td>
				<td style="width:40%"><?=$group->group_name?></td>
				<td style="width:20%"><?=$group->cnt?></td>
				<td><a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/edit_group/<?=$group->group_id?>" role="button">Edit</a>
					<a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/delete_group/<?=$group->group_id?>" role="button">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>