<div class="basebox pd_lr_10 pd_tb_5">
	<div class="pd_tb_10">
		<table class="table table-hover">
			<tr>
				<th>Number</th>
				<th>Post Contents</th>
				<th>User</th>
				<th>Date</th>
				<th>Edit</th>				
			</tr>
			<?php foreach (array_reverse($res) as $key => $post) { ?>
				<tr>
					<td><?=$key + 1?></td>
					<td><?=mb_substr(strip_tags($post->contents),0,30,'UTF-8')?>....</td>
					<td><?=$post->user_name?></td>
					<td><?=date('Y-m-d',strtotime($post->regdate))?></td>
					<td>
						<a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/edit_post/<?=$post->post_id?>" role="button">Edit</a>
						<a class="btn btn-default btn-xs" href="<?=URL?>/gns_admin/delete_post/<?=$post->post_id?>" role="button">Delete</a>
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
		          	<a href="<?=URL?>/gns_admin/post_list/<?=$i?>" class="btn btn-default btn-sm <?=($currPage==$i)? "active" : ""?>"><?=$i?></a>
		          	<?php } ?>
		        </div>
		        <div class="btn-group">
		          	<a href="#" class="btn btn-default btn-sm">&raquo;</a>
		        </div>
	      	</div>
		</div>
     </div>
</div>