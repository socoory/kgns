<?php if (!defined("__KGNS__")) exit; ?>

<div class="content basebox pd_20">
	<div class="user_info">
		<div class="user_profile" style="background-image: url('<?=$post->user_profile_image?>')"></div>
		<div class="user_text pd_tb_10">
			<span><strong><?=$post->user_name?></strong></span><br>
			<span><?=$post->regdate?></span>
		</div>
	</div>
	<div class="content_text clearfix">
		<p><?=nl2br($post->contents)?></p>
	</div>
	
	<div class="comments">
		<div class="input_row">
			<h4>Comments</h4>
			<form method="POST" action="<?=URL?>/timeline/comment">
				<input type="hidden" name="post_id" value="<?=$post->post_id?>">
				<div class="form-group">
					<textarea class="form-control" name="content" rows="2"></textarea>
				</div>
				<div class="form-group clearfix">
					<button type="submit" class="btn btn-default pull-right" style="background-color: #EEE">comment</button>
				</div>
			</form>
		</div>
		<?php foreach($comments as $comment) { ?>
		<div class="comment_block clearfix">
			<div class="user_profile" style="background-image: url('<?=$comment->user_profile_image?>')"></div>
			<div class="user_text pd_tb_10">
				<span><strong><?=$post->user_name?> </strong></span>
				<span class="regdate"> : <?=$comment->regdate?></span>
				<p><?=nl2br($comment->contents)?></p>
			</div>
		</div>
		<?php } ?>
	</div>
</div>