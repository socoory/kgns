<?php if (!defined("__KGNS__")) exit; ?>

<div class="row">
<?php foreach($posts as $key => $post) { ?>
<div class="col-sm-4 pd_lr_15">
<div class="content basebox pd_20">
	<div class="user_info">
		<div class="user_profile" style="background-image: url('<?=$post->user_profile_image?>')"></div>
		<div class="user_text pd_tb_10">
			<span><strong><?=$post->user_name?></strong></span><br>
			<span class="regdate"><?=$post->regdate?></span>
		</div>
	</div>
	<div class="content_text clearfix">
		<p style="height: 40px;"><?=mb_substr($post->contents, 0, 40, 'UTF-8').'...'?></p>
		<a href="<?=URL?>/timeline/read/<?=$post->post_id?>">
			<button class="btn btn-default pull-right btn-xs" style="background-color: #F6F6F6">"Read more"</button>
		</a>
	</div>
</div>
</div>
<?php }?>
</div>