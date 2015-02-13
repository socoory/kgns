<?php if (!defined("__KGNS__")) exit; ?>

<div class="content text-center pd_20">
	<form id="write_form" class="col-md-10 center_block" action="<?=URL?>/timeline/post" method="post">
		<div class="form-group">
			<textarea class="form-control" name="content" rows="10"></textarea>
		</div>
		<div class="form-group text-center">
			<button type="submit" class="btn btn-danger">SUBMIT</button>
		</div>
	</form>
</div>