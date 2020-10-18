<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('account', 'Hide My Profile')?></li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
		
			<p><?php echo $account->status == Account::HIDE ? 'Do you want to active your account?' : 'If you wish to temporarily remove your profile from the site you may wish to hide it rather than deleting it.'?></p>
			<form class="form-horizontal" action="<?php echo url('/tutor/hide')?>" method="post">
				<input type="hidden" name="hide" value="1" />
				<a href="<?php echo url('/tutor/index')?>" class="m-btn input-medium"><?php echo Common::translate('account', 'Cancel')?></a>
				<button type="submit" class="m-btn input-medium"><?php echo Common::translate('account', 'Confirm')?></button>
			</form>
		</div>
	</div>
</div>
<!--/span-->
