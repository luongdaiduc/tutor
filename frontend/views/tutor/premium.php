<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/upgrade')?>"><?php echo Common::translate('account', 'Billing')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Upgrade')?></li>
		</ul>
	</div>

	<div class="row-fluid">

		<?php 
			if(!empty($premium) && !empty($premium->blocks))
			{
				foreach ($premium->blocks as $block)
				{
					if($premium->status == Block::PUBLISHED)
					{
						$this->beginWidget('zii.widgets.CPortlet', array('htmlOptions'=>array('class'=>'')));
						echo $block->body;
						$this->endWidget();
					}
				}
			}
		?>

		
		<div class="span7">
			<?php if(!empty($subjects)) {?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th><?php echo Common::translate('account', 'Subject')?></th>
							<th><?php echo Common::translate('account', 'Availability')?></th>
							<th><?php echo Common::translate('account', 'Amount')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($subjects as $subject) {?>
						<tr>
							<td><?php echo $subject->name?></td>
							<td><?php echo $subject->available_date > time() ? date('j M Y', $subject->available_date) : 'Now'?></td>
							<td><?php echo CHtml::dropDownList('premium', '', Subscription::model()->getPremium($subject->id), array('id'=>$subject->id, 'class'=>'premium_choice', 'empty'=>''))?></td>
						</tr>
						
						<?php }?>
						<tr>
							<td></td>
							<td style="text-align: right"><strong><?php echo Common::translate('account', 'Total')?></strong>
							</td>
							<td><strong><?php echo $this->settings['default_currency_symbol']?><span id="total">0</span></strong>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td><span id="premium_upgrade"><a href="#" class="btn btn-primary"><?php echo Common::translate('account', 'Upgrade')?></a></span></td>
						</tr>
					</tbody>
				</table>

			<?php } else { echo 'You have no subject to upgrade.';}?>
		</div>
	</div>



</div>
<!--/span-->
