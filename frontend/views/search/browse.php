<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('register', 'Home')?>Home</a> <span class="divider">/</span></li>
			<li><a href="<?php echo url('/search')?>"><?php echo Common::translate('search', 'Tutors')?></a> <span class="divider">/</span></li>
			<li><?php echo Common::translate('search', 'Browse')?></li>
		</ul>
	</div>

	<?php $this->renderPartial('_result', array('dataProvider'=>$dataProvider, 'subject'=>$subject))?>
</div>

