					<div class="basebox pd_lr_10 pd_tb_5">
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
									<td><?=$user->id?></td>
									<td><?=$user->email?></td>
									<td><?=$user->name?></td>
									<td><?=$user->regdate?></td>
									<td><?=$user->group_id?></td>
									<td><a class="btn btn-default btn-xs" href="./edit_user/<?=$user->id?>" role="button">Edit</a></td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
					
					
