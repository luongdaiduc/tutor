<div class="control-group">
	<label class="control-label" for="">First Name*</label>
	<div class="controls">
		<?php echo $form->textField($model, 'first_name', array('class'=>'input-xlarge', 'placeholder'=>'First Name'))?>
		<?php echo $form->error($model, 'first_name')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="">Last Name*</label>
	<div class="controls">
		<?php echo $form->textField($model, 'last_name', array('class'=>'input-xlarge', 'placeholder'=>'Last Name'))?>
		<?php echo $form->error($model, 'last_name')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="">Email*</label>
	<div class="controls">
		<?php echo $form->textField($model, 'email', array('class'=>'input-xlarge', 'placeholder'=>'Email'))?>
		<?php echo $form->error($model, 'email')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="">Password*</label>
	<div class="controls">
		<?php echo $form->passwordField($model, 'password', array('class'=>'input-xlarge', 'placeholder'=>'Password'))?>
		<?php echo $form->error($model, 'password')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="">Confirm Password</label>
	<div class="controls">
		<?php echo $form->passwordField($model, 'passwordRepeat', array('class'=>'input-xlarge', 'placeholder'=>'Confirm Password'))?>
		<?php echo $form->error($model, 'passwordRepeat')?>
	</div>
</div>


