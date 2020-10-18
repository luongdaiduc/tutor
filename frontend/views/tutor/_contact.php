<div class="tab-pane fade in active" id="">
	<div class="span6">
		<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'advertise-detail-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>"form-horizontal"),
		)); ?>
			
			<p><?php echo Common::translate('profile', 'Fields with * are required')?>.</p>
			
			<div class="control-group">
				<label class="control-label" for="inputEmail"><?php echo Common::translate('profile', 'Name')?>*</label>
				<div class="controls">
					<?php echo $form->textField($model, 'name', array('placeholder'=>Common::translate('profile', 'Name')));?>
					<?php echo $form->error($model, 'name'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail"><?php echo Common::translate('profile', 'Email')?>*</label>
				<div class="controls">
					<?php echo $form->textField($model, 'email', array('placeholder'=>Common::translate('profile', 'Email')));?>
					<?php echo $form->error($model, 'email'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword"><?php echo Common::translate('profile', 'Message')?>*</label>
				<div class="controls">
					<?php echo $form->textArea($model, 'message', array('placeholder'=>Common::translate('profile', 'Message'), 'rows'=>'3', 'class'=>'input-xlarge'));?>
					<?php echo $form->error($model, 'message'); ?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="m-btn input-medium">
						<?php echo Common::translate('profile', 'Submit')?> <i class="m-icon-swapright"></i>
					</button>
				</div>
			</div>
		<?php $this->endWidget();?>
	</div>
	<div class="span6">
		<address>
			<strong><?php echo $account->profiles->company?></strong><br> <?php echo $account->profiles->address?><br>
			<?php echo $account->profiles->suburb . ', ' . $account->profiles->states->state . ' ' . $account->profiles->post_code;?><br> <?php if (!empty($account->profiles->phone)) {?><abbr title="Phone"><?php echo Common::translate('profile', 'Phone')?>: </abbr><?php }?> <?php echo $account->profiles->phone;?><br>
		</address>
	</div>
</div>
<!--/.contact tab -->