<div class="span2">
	
	<ul class="nav nav-list tutor-nav-list">
		<?php if(!app()->user->isGuest):?>
		<li><a href="<?php echo url('/setting/home')?>" >Settings</a></li>
		<li><a href="<?php echo url('/subscription')?>">Subscriptions</a></li>
		<li><a href="<?php echo url('/state')?>">States</a></li>
		<li class="divider"></li>
		<li><a href="<?php echo url('/subject')?>">Subjects</a></li>
		<li><a href="<?php echo url('/level')?>">Subject Levels</a></li>
		<li><a href="<?php echo url('/delivery')?>">Deliveries</a></li>
		<li><a href="<?php echo url('/page')?>">Pages</a></li>
		<li><a href="<?php echo url('/block')?>">Blocks</a></li>
		<li><a href="<?php echo url('/faq')?>">FAQs</a></li>
		<li class="divider"></li>
		<li class="nav-header"><a href="<?php echo url('/user')?>">Users</a></li>
		<li><a href="<?php echo url('/user')?>">Search</a></li>
		<li><a href="<?php echo url('/user')?>">Browse</a></li>
		<li class="divider"></li>
		<li class="nav-header"><a href="<?php echo url('/mailer/queue')?>">Mailers</a></li>

		<li><a href="<?php echo url('/mailer/queue')?>">Queue</a></li>
		<li><a href="<?php echo url('/mailer/template')?>">Template</a></li>
		<li class="divider"></li>
		<li class="nav-header"><a href="<?php echo url('#')?>">Translation</a></li>
		<?php if(!empty($this->categories)) {?>
			<?php foreach($this->categories as $category) {?>
				<li>
					<a href="<?php echo url('/translation/translate', array('category'=>$category))?>"><?php echo ucfirst($category);?></a>
				</li>
			<?php }?>
		<?php }?>
		<li class="divider"></li>
		<li class="nav-header"><a href="<?php echo url('/site/changePassword')?>">Change Password</a></li>
		
		<?php endif; ?>
		<li></li>
	</ul>
	
</div>
