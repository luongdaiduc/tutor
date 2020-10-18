<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('account', 'Close Account')?></li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<p><?php echo Common::translate('account', 'Please confirm you wish to delete your account')?>.</p>
			<form class="form-horizontal" action="<?php echo url('/tutor/close')?>" method="post">
				<input type="hidden" name="hide" value="1" />
				<a href="<?php echo url('/tutor/index')?>" class="m-btn input-medium"><?php echo Common::translate('account', 'Cancel')?></a>
				<button type="submit" class="m-btn input-medium"><?php echo Common::translate('account', 'Confirm')?></button>
			</form>
		</div>
	</div>
</div>
<!--/span-->
