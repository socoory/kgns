<?php if (!defined("__KGNS__")) exit; ?>

<?php foreach($posts as $post) { ?>
<div class="content basebox pd_20">
	<div class="user_info">
		<div class="user_profile" style="background-image: url('<?=$post->user_profile_image?>')"></div>
		<div class="user_text pd_tb_10">
			<span class="user_name"><strong><?=$post->user_name?></strong></span><br>
			<span class="regdate"><?=$post->regdate?></span>
		</div>
	</div>
	<div class="content_text clearfix">
		<p><?=nl2br($post->contents)?></p>
		<div class="text-center pd_tb_20">
			<?php require_once 'libs/functions.php'; ?>
			<?php foreach($post->attachImage as $attach) {
					if(!isset($imageTitle)) {
						echo '<hr class="pd_0" />';
						$imageTitle = TRUE;
					}
			?>
				<img class="attach_img_thumb img-thumbnail" src="<?=getThumb(URL.'/'.$attach->file_url)?>" data-toggle="modal" data-target="#timelineModal" />
			<?php } ?>
		</div>
		<p>
			<?php foreach($post->attachFile as $attach) {
					if(!isset($fileTitle)) {
						echo '<code class="pd_lr_5 va_mid"> Attached files:</code>';
						$fileTitle = TRUE;
					} 
			?>
				<button type="button" class="btn btn-link btn-xs"><?=$attach->file_name?></button>
			<?php } ?>
		</p>
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
				<span class="user_name"><strong><?=$comment->user_name?> </strong></span>
				<span class="regdate"> : <?=$comment->regdate?></span>
				<p><?=nl2br($comment->contents)?></p>
			</div>
		</div>
		<?php } ?>
		<?php endif; ?>
	</div>
</div>
<?php }?>

<style>
	#modalWrap {
		position: fixed;
		left: 50%;
		top: 50%;
		height: 0;
	}
	
	.modal-dialog {
		margin: 0 auto;
		height: 0;
	}
	
	.modal-content {
		transform: translate(-50, -50%) !important;
		-ms-transform: translate(-50, -50%) !important; /* IE 9 */
		-webkit-transform: translate(-50%, -50%) !important; /* Safari and Chrome */
	}
	
	.modal-body > img {
		width: 100%;
	}
</style>

<div class="modal fade" id="timelineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div id="modalWrap">
		<div class="modal-dialog">
		    <div class="modal-content pd_0">
		    	<div class="modal-body">
		    	</div>
		    </div>
		</div>
	</div>
</div>

<script>
	$(".attach_img_thumb").click(function(event) {
		$(".modal-body").html('<img src="' + event.target.src.replace("thumb_100x100_", "") + '" />');
	});
</script>