<div class="control-group">
	<?php 
		$audiences = $advertise->audiences;
		$audiences = explode(', ', $audiences);
		
		$deliveries = Delivery::model()->allDeliveries();
		$is_feature = $advertise->accounts->is_enhance == Account::ENHANCE || $advertise->accounts->isPremium($advertise->ref_account_id);
		
	?>
	<label class="control-label" for="inputName"><?php echo Common::translate('register', 'Url')?>*</label>
	<div class="controls">
		<?php if(app()->controller->id == 'tutor') {?>
		
			<label style="margin-top: 5px;"><?php echo $is_feature ? Account::profileLink($advertise->ref_account_id) : app()->params['siteUrl'] . Account::profileLink($advertise->ref_account_id)?></label>
			
		<?php } else {?>
		
			<?php echo $form->textField($advertise, 'domain', array('class'=>'input-medium', 'placeholder'=>Common::translate('register', 'Domain')))?>.<?php echo app()->params['domain_name']?>
			<label><?php echo Common::translate('register', 'Personal urls are only available to paid advertisements. Only letters and dashes are allowed')?>.</label>
			<?php echo $form->error($advertise, 'domain')?>
			
		<?php }?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="inputName"><?php echo Common::translate('register', 'Title')?>*</label>
	<div class="controls">
		<?php echo $form->textField($advertise, 'title', array('class'=>'input-xlarge', 'placeholder'=>Common::translate('register', 'Name')))?>
		<?php echo $form->error($advertise, 'title')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="inputEmail"><?php echo Common::translate('register', 'Summary')?>*</label>
	<div class="controls">
		<?php echo $form->textArea($advertise, 'summary', array('class'=>'span8', 'rows'=>'3', 'placeholder'=>Common::translate('register', 'Summary')))?>
		<?php echo $form->error($advertise, 'summary')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="inputEmail"><?php echo Common::translate('register', 'Detail')?>*</label>
	<div class="controls">
		<?php echo $form->textArea($advertise, 'detail', array('class'=>'span8', 'rows'=>'6', 'placeholder'=>Common::translate('register', 'Detail')))?>
		<?php echo $form->error($advertise, 'detail')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="optionsRadios"><?php echo Common::translate('register', 'Audience')?>*</label>
	<div class="controls">
		<label class="checkbox inline"> <input type="checkbox"
			name="audiences[]" id="optionsRadios1" value="Private 1-2-1" <?php echo in_array('Private 1-2-1', $audiences) ? 'checked' : '';?> >Private 1-2-1
		</label> <label class="checkbox inline"> <input type="checkbox"
			name="audiences[]" id="optionsRadios1" value="Group" <?php echo in_array('Group', $audiences) ? 'checked' : '';?> >Group
		</label>
		<?php echo $form->error($advertise, 'audiences')?>
	</div>
	
</div>

<div class="control-group">
	<label class="control-label" for="optionsRadios"><?php echo Common::translate('register', 'Delivery')?></label>
	<div class="controls">
		<?php foreach ($deliveries as $delivery) {?>
			<label class="checkbox inline"> 
				<input type="checkbox" name="deliveries[]" id="" value="<?php echo $delivery->id;?>" <?php echo in_array($delivery->id, $checked_deliveries) ? 'checked' : '';?> ><?php echo $delivery->name;?>
			</label>
		<?php }?>
	</div>
</div>

