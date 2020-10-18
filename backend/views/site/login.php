<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span></li>
			<li class="active">login</li>
		</ul>
	</div>

	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
		)); ?>
		
		<div class="form-line">
			<label class="sf-label required" for="">Email *</label>
			<?php echo $form->textField($model, 'username', array('placeholder'=>'Email', 'class'=>'sf-input'));?>
			<?php echo $form->error($model, 'username'); ?>
		</div>
		<div class="form-line">
			<label class="sf-label required" for="">Password *</label>
			<?php echo $form->passwordField($model, 'password', array('placeholder'=>'Password', 'class'=>'sf-input'));?>
			<?php echo $form->error($model, 'password'); ?>
		</div>
		<div class="form-line">
			<label class="checkbox">
				<?php echo $form->checkBox($model,'rememberMe'); ?> Remember me
			</label>

			<button type="submit" class="m-btn input-medium">
				Login <i class="m-icon-swapright"></i>
			</button>

		</div>
		<?php $this->endWidget(); ?>
	</div>
	<!-- form -->

</div>
<!--/span-->

