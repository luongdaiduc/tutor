<div class="control-group">
	<label class="control-label" for="inputName">Url*</label>
	<div class="controls">
		<?php echo $form->textField($advertise, 'domain', array('class'=>'input-medium', 'placeholder'=>'Domain'))?>.<?php echo app()->params['domain_name']?>
		<label>Personal urls are only available to paid advertisements. Only letters and dashes are allowed.</label>
		<?php echo $form->error($advertise, 'domain')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="inputName">Title*</label>
	<div class="controls">
		<?php echo $form->textField($advertise, 'title', array('class'=>'input-xlarge', 'placeholder'=>'Name'))?>
		<?php echo $form->error($advertise, 'title')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="inputEmail">Summary*</label>
	<div class="controls">
		<?php echo $form->textArea($advertise, 'summary', array('class'=>'span8', 'row'=>'3', 'placeholder'=>'Summary'))?>
		<?php echo $form->error($advertise, 'summary')?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="inputEmail">Detail*</label>
	<div class="controls">
		<?php echo $form->textArea($advertise, 'detail', array('class'=>'span8', 'row'=>'6', 'placeholder'=>'Detail'))?>
		<?php echo $form->error($advertise, 'detail')?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="optionsRadios">Audience*</label>
	<div class="controls">
		<label class="checkbox inline"> <input type="checkbox"
			name="audiences[]" id="optionsRadios1" value="Private 1-2-1" >Private 1-2-1
		</label> <label class="checkbox inline"> <input type="checkbox"
			name="audiences[]" id="optionsRadios1" value="Group" >Group
		</label>
		<?php echo $form->error($advertise, 'audiences')?>
	</div>
	
</div>

<div class="control-group">
	<label class="control-label" for="optionsRadios">Delivery</label>
	<div class="controls">
		<?php foreach ($deliveries as $delivery) {?>
			<label class="checkbox inline"> 
				<input type="checkbox" name="deliveries[]" id="" value="<?php echo $delivery->id;?>" ><?php echo $delivery->name;?>
			</label>
		<?php }?>
	</div>
</div>

