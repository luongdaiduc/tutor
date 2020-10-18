<div class="row-fluid">
	<div class="span12">
		<h2><?php echo Common::translate('home', 'Latest Tutors')?></h2>
		<?php if(!empty($lastests)) {?>
			<table class="table table-striped table-hover table-condensed"
				name="results">
				<thead>
					<th><?php echo Common::translate('home', 'Name')?></th>
					<th><?php echo Common::translate('home', 'Location')?></th>
					<th><?php echo Common::translate('home', 'Rate')?></th>
					<th><?php echo Common::translate('home', 'Subjects')?></th>
				</thead>
				<tbody>
					<?php foreach ($lastests as $lid => $lastest): ?>
						<tr>
							<td><a href="<?php echo Account::profileLink($lastest->id)?>"><?php echo $lastest->first_name . ' ' . $lastest->last_name;?> </a></td>
							<td><?php echo $lastest->profiles->suburb?></td>
							<td><?php echo Common::formatCurrency($lastest->profiles->default_hourly_rate)?></td>
							<td><?php echo $lastest->allSubjects;?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			
			<p>
				<a class="m-btn" href="<?php echo url('/search/result')?>"><?php echo Common::translate('home', 'View more')?> <i class="m-icon-swapright"></i>
				</a>
			</p>
		<?php }?>
	</div>
</div>
