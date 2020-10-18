<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/upgrade')?>"><?php echo Common::translate('account', 'Billing')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Summary')?></li>
		</ul>
	</div>

	<div class="row-fluid">

		<div class="span12">

			<div class="row-fluid">
		        <div class="span6">
		             <div class="hero-unit" style="margin-bottom: 10px; padding-bottom:1px; padding-top: 10px">
		                <form class="form-horizontal" method="post">
						<?php if($account->is_enhance == Account::ENHANCE) {?>
							<?php echo Common::translate('account', 'You currently have a silver package expiring')?> <?php echo date('d M Y', $account->enhance_expire)?>
						<?php } else {?>
		                        <?php echo Common::translate('account', 'You currently have a free basic account')?>
		                        <a href="<?php echo url('/tutor/upgrade')?>" class="m-btn input-small"><?php echo Common::translate('account', 'Upgrade')?></a>
						                 
						<?php }?>
						</form>
		             </div>
		        </div>
		   	</div>

		</div>
	</div>

	<div class="row-fluid">

		<div class="span6">

<!-- 			[if user has any premium subscriptions show following table:-] -->

			<p>
			
			<?php if(!empty($tutor_premiums)) {?>
				
				<h4>Gold packages</h4>
				
				<table class="table table-bordered">
					<thead>
						<tr>
							<th><?php echo Common::translate('account', 'ProfileSubject')?></th>
							<th><?php echo Common::translate('account', 'ProfileStart Date')?></th>
							<th><?php echo Common::translate('account', 'ProfileExpiry')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tutor_premiums as $tutor_premium) {?>
							<tr>
								<td><?php echo $tutor_premium->subjects->name?></td>
								<td><?php echo date('j M Y', $tutor_premium->start_date)?></td>
								<td><?php echo $tutor_premium->expire_date > time() ? date('j M Y', $tutor_premium->expire_date) : 'Now'?></td>
							</tr>
						<?php }?>
					</tbody>
				</table	>
			<?php }?>
			</p>

		</div>
	</div>



</div>
<!--/span-->
