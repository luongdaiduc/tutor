<?php $city = $this->settings['city']?>
<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="<?php echo app()->params['siteUrl'] . url('/')?>"><?php echo Common::translate('register', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo app()->params['siteUrl'] . url('/search/index')?>"><?php echo Common::translate('profile', 'Tutors')?></a> <span class="divider">/</span>
			</li>
			<li><a href="#"><?php echo $city?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo $this->action->id == 'detail' ? 'Profile' : ucfirst($this->action->id)?></li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">

			<div class="page-header">
				<span class="pull-right"> <?php echo $account->profiles->showRatingStar($account->id)?>
				</span>
				<h1>
					<?php echo $account->first_name . ' ' . $account->last_name;?> <small> <?php echo Common::translate('profile', 'tutor in')?> <?php echo $city?></small>
				</h1>
			</div>
			<!--/.page-header -->

			<ul class="nav nav-tabs" id="">
				<li <?php echo $this->action->id == 'detail' ? 'class="active"' : '' ?> ><a href="<?php echo Account::profileLink($account->id)?>" id=""><?php echo Common::translate('profile', 'Profile')?></a>
				</li>
				<?php if($account->hasGallery()) {?>
					<li <?php echo $this->action->id == 'gallery' ? 'class="active"' : '' ?> ><a href="<?php echo Account::profileLink($account->id, '/tutor/gallery')?>"><?php echo Common::translate('profile', 'Gallery')?></a>
					</li>
				<?php }?>
				<?php if($this->settings['video_enable'] == 1 && $account->hasVideo()) {?>
					<li <?php echo $this->action->id == 'video' ? 'class="active"' : '' ?> ><a href="<?php echo Account::profileLink($account->id, '/tutor/video')?>"><?php echo Common::translate('profile', 'Video')?></a>
					</li>
				<?php }?>
				<li <?php echo $this->action->id == 'review' ? 'class="active"' : '' ?> ><a href="<?php echo Account::profileLink($account->id, '/tutor/review')?>"><?php echo Common::translate('profile', 'Reviews')?></a>
				</li>
				<li <?php echo $this->action->id == 'contact' ? 'class="active"' : '' ?> ><a href="<?php echo Account::profileLink($account->id, '/tutor/contact')?>"><?php echo Common::translate('profile', 'Contact')?></a>
				</li>
			</ul>

			<div class="tab-content">
				
				<?php $this->renderPartial($view, $array)?>
				
			</div>
			<!--/.tab-content -->

		</div>
	</div>

</div>
<!--/span-->
