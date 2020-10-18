<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Settings</li>
		</ul>
	</div>

	<?php $this->renderPartial('/setting/_menu')?>

	<form class="form-horizontal" method="POST">
		<div class="tab-content">
				
			<div class="" id="">
				<?php if (isset($message)):?>
					<p class="alert-success"><?php echo $message;?></p>
				<?php endif;?>
	
				<div class="control-group">
					<label class="control-label" for="inputEmail">Company</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Company Name" value="<?php echo $invoice_company->value?>" name="invoice_company">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Address</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Address" value="<?php echo $invoice_address->value?>" name="invoice_address">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Suburb</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Suburb" value="<?php echo $invoice_suburb->value?>" name="invoice_suburb">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">State</label>
					<div class="controls">
						<?php echo CHtml::dropdownList('invoice_state', $invoice_state->value, $this->states, array('class'=>'span2'))?>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Post Code</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Post Code" value="<?php echo $invoice_postcode->value?>" name="invoice_postcode">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Footer</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Footer" value="<?php echo $invoice_footer->value?>" name="invoice_footer">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">GST Enabled</label>
					<div class="controls">
						<input type="checkbox" <?php echo $gst_enable->value == 1 ? 'checked' : ''?> name="gst_enable">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">GST Rate</label>
					<div class="controls">
						<input class="input-mini" type="text" placeholder="GST Rate" value="<?php echo $gst_rate->value?>" name="gst_rate">%
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Sandbox Mode</label>
					<div class="controls">
						<input type="checkbox" <?php echo $paypal_sandbox_mode->value == 1 ? 'checked' : ''?> name="paypal_sandbox_mode">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Paypal Email</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Paypal Email" value="<?php echo $paypal_email->value?>" name="paypal_email">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Paypal Return Text</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Paypal Return Text" value="<?php echo $paypal_return_text->value?>" name="paypal_return_text">
					</div>
				</div>
			
				<button type="submit" class="m-btn input-medium">
					Save <i class="m-icon-swapright"></i>
				</button>
				
			</div>
		</div>
	</form>
</div>
