<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/subscription')?>">Subscriptions</a> <span
				class="divider">/</span>
			</li>
			<li class="active">Create</li>
		</ul>
	</div>

	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'subscription-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>'form-horizontal'),
	)); ?>
	
		<div class="control-group">
			<label class="control-label">Title*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'title', array('class'=>'input-large', 'placeholder'=>'Title'))?>
				<?php echo $form->error($model, 'title')?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Type</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'type', array(Subscription::ENHANCE=>'Enhanced', Subscription::PREMIUM=>'Premium'), array('class'=>'input-medium'))?>
			</div>
		</div>
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputName">Currency</label> -->
<!-- 			<div class="controls"> -->
				<?php //echo $form->dropDownList($model, 'currency', array('GBP'=>'GBP', 'USD'=>'USD'), array('class'=>'input-small'))?>
<!-- 			</div> -->
<!-- 		</div> -->
		<div class="control-group">
			<label class="control-label">Amount*</label>
			<div class="controls">
				<div>
					<?php echo $this->settings['default_currency_symbol']?>
					<?php echo $form->textField($model, 'amount', array('class'=>'input-small', 'placeholder'=>'Amount'))?>
				</div>
				<?php echo $form->error($model, 'amount')?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputName">Period</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'period', array('1 Month'=>'1 Month', '2 Months'=>'2 Months', '3 Months'=>'3 Months', '6 Months'=>'6 Months', '12 Months'=>'12 Months'), array('class'=>'input-medium'))?>
			</div>
		</div>

		<a href="<?php echo url('/subscription')?>" class="m-btn input-medium">Cancel <i
			class="m-icon-swapright"></i>
		</a>

		<button type="submit" class="m-btn input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>

	<?php $this->endWidget();?>

</div>
<!--/span-->
