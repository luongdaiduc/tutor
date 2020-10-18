<div class="tab-pane fade in active" id="">
	<dl class="dl-horizontal tutor-profile-dl">
		<dt><?php echo Common::translate('profile', 'Gender')?></dt>
		<dd><?php echo $profile->gender;?></dd>
		<dt><?php echo Common::translate('profile', 'Location')?></dt>
		<dd><?php echo $profile->suburb;?></dd>
		<dt><?php echo Common::translate('profile', 'Audience')?></dt>
		<dd><?php echo $advertise->audiences;?></dd>
		
		<?php if(!empty($advertise->allDeliveries)) {?>
			<dt><?php echo Common::translate('profile', 'Delivery')?></dt>
			<dd><?php echo $advertise->allDeliveries?></dd>
		<?php }?>
		
		<?php if(!empty($profile->website)) {?>
			<dt><?php echo Common::translate('profile', 'Website')?></dt>
			<dd>
				<a href="<?php echo $profile->website?>" target="_blank"><?php echo $profile->website?></a>
			</dd>
		<?php }?>
		
	</dl>

	<dl>
		<dt><?php echo Common::translate('profile', 'Description')?></dt>
		<dd>
			<p><?php echo $advertise->detail;?></p>
		</dd>
		<dt><?php echo Common::translate('profile', 'Subjects')?></dt>
		<dd>
			<table class="table table-striped table-hover table-condensed"
				name="results">
				<thead>
					<tr>
						<th><?php echo Common::translate('profile', 'Name')?></th>
						<th><?php echo Common::translate('profile', 'Levels')?></th>
						<th><?php echo Common::translate('profile', 'Experience')?></th>
						<th><?php echo Common::translate('profile', 'Rate')?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if(!empty($tutor_subjects))
						{
							foreach ($tutor_subjects as $subject)
							{
					?>
								<tr>
									<td style="width: 50%;"><?php echo $subject->subjects->name?></a>
									</td>
									<td style="width: 20%;"><?php echo !empty($subject->subject_levels->name) ? $subject->subject_levels->name : '';?></td>
									<td style="text-align: right; width: 15%;"><?php echo $subject->experience?></td>
									<td style="width: 15%;"><?php echo Common::formatCurrency($subject->hourly_rate)?></td>
								</tr>
					<?php 
							}
						}
					?>
				</tbody>
			</table>
		</dd>
	</dl>
</div>
<!--/.profile tab -->
