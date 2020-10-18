
<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('content', 'Home')?></a> <span class="divider">/</span></li>
			<li class="active"><?php echo Common::translate('content', 'FAQs')?></li>
		</ul>
	</div>

	<div class="page-header">
		<h1><?php echo Common::translate('content', 'FAQs')?></h1>
	</div>

	<?php if(!empty($generals)) {?>
	<h3><?php echo Common::translate('content', 'General')?></h3>
	<div class="accordion events" id="accordion<?php echo Faq::GENERAL?>">
		<!-- Each item should be enclosed inside the class "accordion-group". Note down the below markup. -->
		<?php foreach ($generals as $general) {?>
			<?php $this->renderPartial('_faq_item', array('data'=>$general))?>
		<?php }?>
	</div>
	<?php }?>

	<?php if(!empty($students)) {?>
	<h3><?php echo Common::translate('content', 'Students')?></h3>
	<div class="accordion events" id="accordion<?php echo Faq::STUDENT?>">
		<!-- Each item should be enclosed inside the class "accordion-group". Note down the below markup. -->
		<?php foreach ($students as $student) {?>
			<?php $this->renderPartial('_faq_item', array('data'=>$student))?>
		<?php }?>
	</div>
	<?php }?>

	<?php if(!empty($tutors)) {?>
	<h3><?php echo Common::translate('content', 'Tutors')?></h3>
	<div class="accordion events" id="accordion<?php echo Faq::TUTOR?>">
		<!-- Each item should be enclosed inside the class "accordion-group". Note down the below markup. -->
		<?php foreach ($tutors as $tutor) {?>
			<?php $this->renderPartial('_faq_item', array('data'=>$tutor))?>
		<?php }?>
	</div>
	<?php }?>

</div>
<!--/span-->
