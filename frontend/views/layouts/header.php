<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="m-btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</a> 
			<a class="brand" href="<?php echo app()->params['siteUrl'] . url('/')?>"><?php echo $this->settings['site_title']?>
			</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="<?php echo app()->params['siteUrl'] . url('/site/shortlist')?>"><?php echo Common::translate('header', 'My Shortlist')?></a>
					</li>
					<li><a href="<?php echo app()->params['siteUrl'] . url('/site/faq')?>"><?php echo Common::translate('header', 'FAQs')?></a>
					</li>
					<li <?php echo $this->action->id == 'contact' ? 'class="active"' : ''?>>
						<a href="<?php echo app()->params['siteUrl'] . url('/site/contact')?>"><?php echo Common::translate('header', 'Contact')?></a>
					</li>
				</ul>

				<ul class="nav pull-right">
					<?php 
						$social_network_name = app()->user->getState('socialNetworkName');
						$is_social_network_login = !empty($social_network_name) ? true : false;
					?>
					<?php if(!Yii::app()->user->isGuest) : ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" id='lnkAccount'><?php echo Common::translate('header', 'My Account')?><b class="caret white"></b></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="lnkAccount">
							<?php $this->renderPartial('/layouts/_account_items')?>
						</ul>
					</li>
					<?php endif;?>
					<?php if(!Yii::app()->user->isGuest || $is_social_network_login) : ?>
					<li>
						<a href="<?php echo app()->params['siteUrl'] . url('/site/logout')?>" class="navbar-link"><?php echo Common::translate('header', 'Logout')?></a>
					</li>
					<?php else :?>
					<li>
						<a href="<?php echo app()->params['siteUrl'] . url('/site/login')?>" class="navbar-link"><?php echo Common::translate('header', 'Login')?></a>
					</li>
					<li>
						<a href="<?php echo app()->params['siteUrl'] . url('/register/account')?>" class="navbar-link"><?php echo Common::translate('header', 'Register')?></a>
					</li>
					<?php endif;?>
				</ul>

			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
