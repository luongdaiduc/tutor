<?php $account = $this->getAccount();?>
<li class="nav-header">My Details</li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/index')?>"><?php echo Common::translate('account', 'Summary')?></a></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/account')?>"><?php echo Common::translate('account', 'Login Details')?></a></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/profile')?>"><?php echo Common::translate('account', 'Contact Details')?></a></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/advertise')?>"><?php echo Common::translate('account', 'Advertisement')?></a></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/tutorSubject')?>"><?php echo Common::translate('account', 'Subjects')?></a></li>

<?php if($account->isFeature($account->id)) {?>
<li><a href="<?php echo app()->params['siteUrl'] . url('/photos/index')?>"><?php echo Common::translate('account', 'Gallery')?></a></li>
<?php }?>

<?php if($this->settings['video_enable'] == 1 && $account->isFeature($account->id)) {?>
	<li><a href="<?php echo app()->params['siteUrl'] . url('/videos/index')?>"><?php echo Common::translate('account', 'Videos')?></a></li>
<?php }?>

<li><a href="<?php echo app()->params['siteUrl'] . url('/reviews/index')?>"><?php echo Common::translate('account', 'Reviews')?></a></li>

<?php if(isset($account) && !empty($account)) {?>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/hide')?>"><?php echo $account->status == Account::ACTIVE ? Common::translate('account', 'Hide My Advert') : Common::translate('account', 'Active My Advert')?></a></li>
<?php }?>
<li class="divider"></li>
<li class="nav-header">Billing</li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/status')?>"><?php echo Common::translate('account', 'Summary')?></a></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/upgrade')?>"><?php echo Common::translate('account', 'Upgrade')?></a></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/invoice')?>"><?php echo Common::translate('account', 'Invoices')?></a></li>
<li class="divider"></li>
<li><a href="<?php echo app()->params['siteUrl'] . url('/tutor/close')?>"><?php echo Common::translate('account', 'Close Account')?></a></li>