<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'feature-suggestion-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
				'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array('class'=>""),
)); ?>
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
	
	<p><?php echo Common::translate('content', 'Fields with * are required')?></p>
	
	<div class="control-group">
		<label class="control-label" for="inputEmail"><?php echo Common::translate('content', 'Name')?>*</label>
		<div class="controls">
			<?php echo $form->textField($model, 'name', array('placeholder'=>'Name', 'class'=>'input-xlarge'));?>
			<?php echo $form->error($model, 'name'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputEmail"><?php echo Common::translate('content', 'Email')?>*</label>
		<div class="controls">
			<?php echo $form->textField($model, 'email', array('placeholder'=>Common::translate('content', 'Email'), 'class'=>'input-xlarge'));?>
			<?php echo $form->error($model, 'email'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword"><?php echo Common::translate('content', 'Message')?>*</label>
		<div class="controls">
			<?php echo $form->textArea($model, 'message', array('placeholder'=>Common::translate('content', 'Message'), 'rows'=>'5', 'class'=>'input-xxlarge'));?>
			<?php echo $form->error($model, 'message'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="m-btn input-medium">
				<?php echo Common::translate('content', 'Submit')?> <i class="m-icon-swapright"></i>
			</button>
		</div>
	</div>
<?php $this->endWidget();?>