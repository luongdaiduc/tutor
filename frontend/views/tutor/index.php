<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('account', 'My Account')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php $this->renderPartial('/site/_block', array('page'=>$page))?>
		</div>
	</div>

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
    
	
	<div class="row-fluid">

		<div class="span6" style="margin-top: 20px">

			<table class="table">
				<tbody>
					<tr>
						<td><?php echo Common::translate('account', 'Member since')?>:</td>
						<td style="text-align: right"><?php echo date('d F Y', strtotime($account->created))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Last login')?>:</td>
						<td style="text-align: right"><?php echo !empty($account->previous_login) ? date('d F Y', strtotime($account->previous_login)) : date('d F Y', strtotime($account->last_login))?></td>
					</tr>
				</tbody>
			</table>

			<table class="table">
				<thead>
					<tr>
						<th colspan="2"><?php echo Common::translate('account', 'Profile Views')?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo Common::translate('account', 'Current Month')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_VIEW, 'month', date('m'))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Previous Month')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_VIEW, 'month', date('m', strtotime('-1 month')))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Current Year')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_VIEW, 'year', date('Y'))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Since Registration')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_VIEW, 'all')?></td>
					</tr>
				</tbody>
			</table>

			<table class="table">
				<thead>
					<tr>
						<th colspan="2"><?php echo Common::translate('account', 'Search Results')?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo Common::translate('account', 'Current Month')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_SEARCH, 'month', date('m'))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Previous Month')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_SEARCH, 'month', date('m', strtotime('-1 month')))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Current Year')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_SEARCH, 'year', date('Y'))?></td>
					</tr>
					<tr>
						<td><?php echo Common::translate('account', 'Since Registration')?></td>
						<td style="text-align: right"><?php echo $account->tutorStatistic(TutorStatistic::PROFILE_SEARCH, 'all')?></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>

</div>
<!--/span-->
