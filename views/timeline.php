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
	</div>
</div>
<?php }?>