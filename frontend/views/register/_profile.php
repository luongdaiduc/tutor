<div class="control-group">
	<?php 
		$salutations = Common::getSalutations();
		$states = $this->states;
		$currencies = Common::getCurrencies();
	?>
	<label class="control-label" for=""><?php echo Common::translate('register', 'Salutation')?></label>
	
	<div class="controls">
		<?php echo $form->dropdownList($profile, 'salutation', $salutations, array('class'=>'span2'))?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Gender')?>*</label>
	<div class="controls">
		<label class="radio  inline"> 
		<input type="radio" name="Profile[gender]" id="male" value="Male" <?php if($profile->gender != null) {echo $profile->gender == 'Male' ? 'checked' : '';}else{ echo 'checked';}?> ><?php echo Common::translate('search', 'Male')?> 
		</label> 
		<label class="radio  inline"> 
		<input type="radio" name="Profile[gender]" id="female" value="Female" <?php echo $profile->gender == 'Female' ? 'checked' : ''?> ><?php echo Common::translate('search', 'Female')?> 
		</label>
	</div>
</div>

<hr />

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Company')?></label>
	<div class="controls">
		<?php echo $form->textField($profile, 'company', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Company')))?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Address')?>*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'address', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Street')))?>
		<?php echo $form->error($profile, 'address')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Suburb')?>*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'suburb', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Suburb')))?>
		<?php echo $form->error($profile, 'suburb')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'State')?>*</label>
	<div class="controls">
	<?php echo $form->dropdownList($profile, 'state', $states, array('class'=>'span2'))?>
	<?php echo $form->error($profile, 'state')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Postcode')?>*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'post_code', array('class'=>'input-mini', 'placeholder'=>Common::translate('register', 'Postcode')))?>
		<?php echo $form->error($profile, 'post_code')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Phone')?></label>
	<div class="controls">
		<?php echo $form->textField($profile, 'phone', array('class'=>'input-small', 'placeholder'=>Common::translate('register', 'Phone')))?>
		<?php echo $form->error($profile, 'phone')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Website')?></label>
	<div class="controls">
		<?php echo $form->textField($profile, 'website', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Website')))?>
		<?php echo $form->error($profile, 'website')?>
	</div>
</div>

<hr />

<div class="control-group">
	<label class="control-label" for=""><?php echo Common::translate('register', 'Default Hourly Rate')?>*</label>
	<div class="controls">
		<div class="">
			<?php echo $form->textField($profile, 'default_hourly_rate', array('class'=>'input-mini', 'size'=>'16'))?>
			<label style="display: inline;"><?php echo $this->settings['currency']?></label>
			<?php echo $form->error($profile, 'default_hourly_rate')?>
			
		</div>
	</div>
</div>


