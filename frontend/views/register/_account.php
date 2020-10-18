<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'First Name')?>*</label>
	<div class="controls">
		<?php echo $form->textField($model, 'first_name', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'First Name')))?>
		<?php echo $form->error($model, 'first_name')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Last Name')?>*</label>
	<div class="controls">
		<?php echo $form->textField($model, 'last_name', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Last Name')))?>
		<?php echo $form->error($model, 'last_name')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Email')?>*</label>
	<div class="controls">
		<?php echo $form->textField($model, 'email', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Email')))?>
		<?php echo $form->error($model, 'email')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Password')?>*</label>
	<div class="controls">
		<?php echo $form->passwordField($model, 'password', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Password')))?>
		<?php echo $form->error($model, 'password')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Confirm Password')?></label>
	<div class="controls">
		<?php echo $form->passwordField($model, 'passwordRepeat', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Confirm Password')))?>
		<?php echo $form->error($model, 'passwordRepeat')?>
	</div>
</div>


