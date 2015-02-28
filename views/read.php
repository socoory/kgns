<?php

	/**
	 * post read page
	 * 
	 * @author Benimario
	 * @since 2015.02
	 */

?>

<?php if (!defined("__KGNS__")) exit; ?>

<div class="read content basebox pd_20">
	<div class="user_info">
		<div class="user_profile" style="background-image: url('<?=$post->user_profile_image?>')"></div>
		<div class="user_text pd_tb_10">
			<span><strong><?=$post->user_name?></strong></span><br>
			<span class="regdate"><?=$post->regdate?></span>
		</div>
	</div>
	<div class="content_text clearfix">
		<p><?=nl2br($post->contents)?></p>
		<p class="attach_images text-center">
			<?php foreach($attachImage as $attach) { ?>
			<img src="<?=URL.'/'.$attach->file_url?>" />
			<?php } ?>
		</p>
		<p>
			<?php foreach($attachFile as $attach) { 
				if(!isset($fileTitle)) {
					echo '<code class="pd_lr_5 va_mid"> Attached files:</code>';
					$fileTitle = TRUE;
				} 
			?>
			<button type="button" class="btn btn-link btn-xs"><?=$attach->file_name?></button>
			<?php } ?>
		</p>
	</div>
	
	<div class="comments">
		<div class="input_row">
			<h5>Comments</h5>
			<form method="POST" action="<?=URL?>/timeline/comment">
				<input type="hidden" name="post_id" value="<?=$post->post_id?>">
				<div class="form-group" style="margin-bottom: 10px;">
					<textarea class="form-control" name="content" rows="2"></textarea>
				</div>
				<div class="form-group clearfix">
					<button type="submit" class="btn btn-default btn-xs pull-right" style="background-color: #EEE">comment</button>
				</div>
			</form>
		</div>
		<?php foreach($comments as $comment) { ?>
		<div class="comment_block clearfix pd_10">
			<div class="user_profile" style="background-image: url('<?=$comment->user_profile_image?>');"></div>
			<div class="user_text">
				<span><strong><?=$comment->user_name?> </strong></span>
				<span class="regdate"> : <?=$comment->regdate?></span>
				<p><?=nl2br($comment->contents)?></p>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<h4 style="margin: 30px 0 5px 0;">OTHER POSTS</h4>