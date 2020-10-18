<?php 
	$salutations = Common::getSalutations();
	$states = $this->states;
	$currencies = Common::getCurrencies();
?>
<div class="control-group">
	<label class="control-label" for="">Salutation</label>
	
	<div class="controls">
		<?php echo $form->dropdownList($profile, 'salutation', $salutations, array('class'=>'span2'))?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="">Gender*</label>
	<div class="controls">
		<label class="radio  inline"> 
		<input type="radio" name="Profile[gender]" id="male" value="Male" <?php if($profile->gender != null) {echo $profile->gender == 'Male' ? 'checked' : '';}else{ echo 'checked';}?> >Male
		</label> 
		<label class="radio  inline"> 
		<input type="radio" name="Profile[gender]" id="female" value="Female" <?php echo $profile->gender == 'Female' ? 'checked' : ''?> > Female
		</label>
	</div>
</div>

<hr />

<div class="control-group">
	<label class="control-label" for="">Company</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'company', array('class'=>'input-xlarge', 'placeholder'=>'Company'))?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="">Address*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'address', array('class'=>'input-xlarge', 'placeholder'=>'Street'))?>
		<?php echo $form->error($profile, 'address')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="">Suburb*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'suburb', array('class'=>'input-xlarge', 'placeholder'=>'Suburb'))?>
		<?php echo $form->error($profile, 'suburb')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="">State*</label>
	<div class="controls">
	<?php echo $form->dropdownList($profile, 'state', $states, array('class'=>'span2'))?>
	<?php echo $form->error($profile, 'state')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="">Postcode*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'post_code', array('class'=>'input-mini', 'placeholder'=>'PostCode'))?>
		<?php echo $form->error($profile, 'post_code')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="">Phone*</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'phone', array('class'=>'input-small', 'placeholder'=>'Phone'))?>
		<?php echo $form->error($profile, 'phone')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="">Website</label>
	<div class="controls">
		<?php echo $form->textField($profile, 'website', array('class'=>'input-xlarge', 'placeholder'=>'Website'))?>
	</div>
</div>

<hr />

<div class="control-group">
	<label class="control-label" for="">Default Hourly Rate*</label>
	<div class="controls">
		<div class="">
			<?php echo $form->textField($profile, 'default_hourly_rate', array('class'=>'input-mini', 'size'=>'16'))?>
			<label style="display: inline;"><?php echo $this->settings['currency']?></label>
			<?php echo $form->error($profile, 'default_hourly_rate')?>
			
		</div>
	</div>
</div>


