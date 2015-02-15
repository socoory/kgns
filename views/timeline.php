<?php if (!defined("__KGNS__")) exit; ?>

<?php foreach($posts as $post) { ?>
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
		<a href="<?=URL?>/timeline/read/<?=$post->post_id?>">
			<button class="btn btn-default pull-right btn-xs" style="background-color: #F6F6F6">"Read more"</button>
		</a>
	</div>
	
	<div class="comments">
		<?php if($post->comments) :?>
		<h4>Recent 3 comments</h4>
		<?php foreach($post->comments as $comment) { ?>
		<div class="comment_block clearfix pd_10">
			<div class="user_profile" style="background-image: url('<?=$comment->user_profile_image?>'); width: 40px; padding: 20px;"></div>
			<div class="user_text">
				<span><strong><?=$post->user_name?> </strong></span>
				<span class="regdate"> : <?=$comment->regdate?></span>
				<p><?=nl2br($comment->contents)?></p>
			</div>
		</div>
		<?php } ?>
		<?php endif; ?>
	</div>
</div>
<?php }?>