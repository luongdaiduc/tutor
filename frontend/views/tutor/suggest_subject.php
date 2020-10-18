<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('account', 'Suggest Subject')?></li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
		
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'subject-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>"form-horizontal"),
			)); ?>
				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('account', 'Suggest Subject')?>*</label>
					<div class="controls">
						<?php echo $form->textField($model, 'subject', array('class'=>'input-medium', 'placeholder'=>Common::translate('account', 'Suggest Subject')))?>
						<?php echo $form->error($model, 'subject')?>
					</div>
				</div>
				
				<a href="<?php echo url('/tutor/tutorSubject')?>" class="m-btn input-medium"><?php echo Common::translate('account', 'Cancel')?></a>
				<button type="submit" class="m-btn input-medium"><?php echo Common::translate('profile', 'Submit')?></button>
			<?php $this->endWidget();?>
		</div>
	</div>
</div>
<!--/span-->
