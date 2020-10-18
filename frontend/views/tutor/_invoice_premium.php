<?php 
	$currency = !empty($invoice->currency) ? $invoice->currency : $setting['currency'];
	$subscription_subject_ids = explode(',', $invoice->subscription_subject_ids);
?>
<p style="font-size: 30px; margin-bottom: 30px;"><strong>INVOICE</strong></p>

<p style="font-size: 20px;"><strong>Document ID: <?php echo $transaction->id?></strong></p>

<p><?php echo date('jS F Y', strtotime($transaction->payment_date))?></p>

<div style="clear: both; margin-bottom: 40px;"></div>
<div style="display: inline;">
	<div style="width: 50%; float: left;">
		<div>From:</div>
		<br/>
		<div><?php echo $settings['invoice_company']?></div>
		<div><?php echo $settings['invoice_address']?></div>
		<div><?php echo $settings['invoice_suburb']?></div>
		<div><?php echo $default_state?></div>
		<div><?php echo $settings['invoice_postcode']?></div>
		<div>Australia</div>
	</div>
	<div style="width: 50%; float: right;">
		<div>To:</div>
		<br/>
		<div><?php echo $account->first_name . ' ' . $account->last_name?></div>
		<div><?php echo $account->profiles->address?></div>
		<div><?php echo $account->profiles->suburb?></div>
		<div><?php echo $account->profiles->states->state?></div>
		<div><?php echo $account->profiles->post_code?></div>
		<div>Australia</div>
	</div>
</div>
<div style="clear: both; margin-bottom: 30px;"></div>
<table class="table table-striped table-hover table-condensed table-fluid">
	<tbody>
		<tr>
			<th style="width: 80%;">Upgrade to gold package</th>
			<td></td>
		</tr>
		<?php if($settings['gst_enable'] == 1) {?>
		
			<?php echo $invoice->invoiceInfo($subscription_subject_ids)?>
			
			<tr>
				<td style="width: 80%; text-align: right;">GST</td>
				<td style="text-align: right;"><?php echo Common::formatCurrency(number_format(($transaction->mc_gross - ($transaction->mc_gross/(1 + $settings['gst_rate']/100))), 2))?></td>
			</tr>
			<tr>
				<td style="width: 80%; text-align: right;"><strong>Total</strong></td>
				<td style="text-align: right;"><strong><?php echo Common::formatCurrency($transaction->mc_gross)?></strong></td>
			</tr>
		<?php } else {?>
			<tr>
				<td style="width: 80%;"><?php echo $transaction->info?></td>
				<td style="text-align: right;"><?php echo Common::formatCurrency($transaction->mc_gross)?></td>
			</tr>
			
			<tr>
				<td style="width: 80%; text-align: right;"><strong>Total</strong></td>
				<td style="text-align: right;"><strong><?php echo Common::formatCurrency($transaction->mc_gross)?></strong></td>
			</tr>
		<?php }?>
	</tbody>
</table>

<style>
	
body {
    color: #333333;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 14px;
	}
table {
    background-color: transparent;
    border-collapse: collapse;
    border-spacing: 0;
    max-width: 100%;
}

.table {
    margin-bottom: 20px;
    width: 100%;
	}
.grid-view .checkbox-column {
    width: 15px;
}
	
.table th, .table td {
	border: 1px solid #DDDDDD;
    line-height: 20px;
    height:20px;
    text-align: left;
    vertical-align: top;
    padding: 5px;
}
	
.fs20 {
	font-size: 16px;
}
</style>

    