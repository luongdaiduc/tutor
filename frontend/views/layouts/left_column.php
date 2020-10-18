<div class="span2">
	<div class="small-search">
		<form action="<?php echo app()->params['siteUrl'] . url('/search/result')?>" method="get">
			<h4><?php echo Common::translate('home', 'Search Tutors')?></h4>
				<?php echo CHtml::dropDownList('subject', '', $this->subjects, array('class'=>'span12', 'empty'=>Common::translate('home', 'Choose Subject')))?>
			<p></p>
			
			<input type="text" placeholder="<?php echo Common::translate('home', 'Postcode')?>" class="span12" name="post_code"> 
			
			<?php echo CHtml::dropDownList('search_km', '', Common::getSearchKmChoices($this->settings['search_km_choices']), array('class'=>'span12'))?>
			<p></p>
			
			<p>
				<button type="submit" class="m-btn span12"><?php echo Common::translate('home', 'Search')?> <i class="icon-search"></i></button>
			</p>
			<a href="<?php echo app()->params['siteUrl'] . url('/search/index')?>"><?php echo Common::translate('home', 'Advanced Search')?></a>
		</form>
	</div>

	<ul class="nav nav-list tutor-nav-list">
		<li class="nav-header"><?php echo Common::translate('home', 'FOR STUDENTS')?></li>
		<li><a href="<?php echo app()->params['siteUrl'] . url('/search/result')?>"><?php echo Common::translate('home', 'Browse Tutors')?></a>
		</li>
		<li><a href="<?php echo app()->params['siteUrl'] . url('/search/index')?>"><?php echo Common::translate('home', 'Search Tutors')?></a>
		</li>
		<li><a href="<?php echo app()->params['siteUrl'] . url('/search/map')?>"><?php echo Common::translate('home', 'Map of Tutors')?></a>
		</li>
		<li><a href="<?php echo app()->params['siteUrl'] . url('/page/rate-your-tutor')?>"><?php echo Common::translate('home', 'Rate your tutor')?></a>
		</li>
		<li class="divider"></li>
		<?php if(app()->user->isGuest) {?>
			<li class="nav-header"><?php echo Common::translate('home', 'FOR TUTORS')?></li>
			<li><a href="<?php echo app()->params['siteUrl'] . url('/register/account')?>"><?php echo Common::translate('home', 'Advertise')?></a>
			</li>
			<li class="divider"></li>
		<?php }?>
		
		<li><a href="<?php echo app()->params['siteUrl'] . url('/site/subjectAvailable')?>"><?php echo Common::translate('home', 'Subjects Available')?></a>
		</li>
		<li><a href="<?php echo app()->params['siteUrl'] . url('/site/feature')?>"><?php echo Common::translate('home', 'Feature Suggestion')?></a>
		</li>
		<li><a href="<?php echo app()->params['siteUrl'] . url('/page/online-safety')?>"><?php echo Common::translate('home', 'Online Safety')?></a>
		</li>
	</ul>

</div>
