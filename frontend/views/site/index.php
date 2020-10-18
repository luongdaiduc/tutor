<div class="span10">

	<?php if(!empty($page) && !empty($page->blocks)) {?>
		
		<?php $this->renderPartial('_block', array('page'=>$page))?>
		
	<?php }?>
	
	<?php $this->renderPartial('_feature', array('feature'=>$feature));?>

	<hr />
	
	<?php if(isset($subject) && !empty($subject) && !empty($teachers)): ?>
	<div class="row-fluid">
		<div class="span12">
			<h2>
				<span id="subject_name"><?php echo $subject->name;?></span> <?php echo Common::translate('home', 'Teachers in')?> <?php echo $this->settings['city']?>
			</h2>
		</div>
	
		<div class="span12 pull-right">
			<div class="input-append">
				<?php echo CHtml::dropDownList('teacher_subjects', $subject->name, $this->subjects)?>
				<button class="m-btn icn-only btn-aligned btn-rnd-right" id="load_teacher"> <?php echo Common::translate('home', 'Load')?><i class="m-icon-swapright"></i></button>
				<img src="<?php echo app()->baseUrl?>/theme/img/loading.gif" id="loading" style="width: 30px; margin-bottom: 10px; display: none;"/>
			</div>
		</div>
	</div>
		
	<div class="row-fluid">
		<div class="span12">
			<div id="random_teacher">
				<?php $this->renderPartial('_random_teacher', array('teachers'=>$teachers, 'subject'=>$subject->name))?>
			</div>
			
		</div>
	</div>
	<?php endif; ?>
	<hr />

	<?php $this->renderPartial('_lastest', array('lastests'=>$lastests))?>
</div>