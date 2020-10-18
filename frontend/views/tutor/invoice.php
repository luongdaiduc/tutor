<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/upgrade')?>"><?php echo Common::translate('account', 'Billing')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Invoices')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
		
			<?php 
				if(!empty($invoices))
				{
			?>
					<table class="table table-striped table-hover table-condensed"name="expertise">
						<thead>
							<tr>
								<th><?php echo Common::translate('account', 'Created')?></th>
								
								<th><?php echo Common::translate('account', 'Amount')?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
									foreach ($invoices as $invoice)
									{
							?>
										<tr>
											<td><a href="<?php echo url('/tutor/createInvoice', array('id'=>$invoice->id));?>" target="_blank"><?php echo date($this->settings['short_date_format'], strtotime($invoice->created));?></a></td>
											
											<td><?php echo Common::formatCurrency($invoice->amount)?></td>
										</tr>
							<?php
									}
							?>
						</tbody>
					</table>
			<?php
				}
				else 
					echo 'No result found.';
			?>
		</div>
	</div>



</div>
<!--/span-->
