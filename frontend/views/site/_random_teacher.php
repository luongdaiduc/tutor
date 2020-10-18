<?php if(!empty($teachers)) {?>
	<table class="table table-striped table-hover table-condensed" name="results">
		<thead>

			<th><?php echo Common::translate('home', 'Name')?></th>
			<th><?php echo Common::translate('home', 'Location')?></th>
			<th><?php echo Common::translate('home', 'Rate')?></th>
			<th><?php echo Common::translate('home', 'Subjects')?></th>

		</thead>
		<tbody>
			<?php foreach ($teachers as $teacher) {?>
			<tr>
				<td>
					<a href="<?php echo Account::profileLink($teacher->ref_account_id)?>">
						<?php echo $teacher->accounts->first_name . ' ' . $teacher->accounts->last_name;?>
					</a>
				</td>
				<td><?php echo $teacher->suburb;?></td>
				<td><?php echo Common::formatCurrency($teacher->default_hourly_rate)?></td>
				<td><?php echo $teacher->accounts->allSubjects;?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<p>
		<a class="m-btn" href="<?php echo url('/search/result', array('subject'=>$subject))?>"><?php echo Common::translate('home', 'View more')?> <i class="m-icon-swapright"></i>
		</a>
	</p>
<?php }?>