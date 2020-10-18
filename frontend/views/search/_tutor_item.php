<?php
$photo = Profile::model()->showTutorPhoto($data->ref_account_id);
$checked_row = in_array($data->id, explode(',', $shortlist_ids));
$checkbox_title = $this->id == 'search' ? 'Add to Shortlist' : 'Remove from Shortlist';
?>

<?php if($index == 0):?>
<tr>
	<th colspan="2"><?php echo Common::translate('search', 'Tutor')?></th>
	<th></th>
	<th><?php echo Common::translate('search', 'From')?></th>
</tr>
<?php endif;?>

<tr <?php echo ($index % 2 == 0) ? 'class="odd"' : ''?>>
	<td class='short-list'>
		<?php echo CHtml::checkBox('chk_tutor_'. $index, $checked_row, array('value'=>$data->id, 'class'=>'select-on-check', 'title'=>$checkbox_title))?>
	</td>
	
	<?php if(!empty($photo)):?>
	<td><div style="width: 160px;"><?php echo $photo?></div></td>
	<?php endif;?>
	
	<td <?php echo (empty($photo)) ? 'colspan="2"' : ''?>>
		<h5>
		<?php echo CHtml::link($data->accounts->first_name . " " . $data->accounts->last_name, Account::profileLink($data->ref_account_id))?>
		<div style="float:right"><?php echo $data->showRatingStar($data->ref_account_id)?></div>
		</h5>
		<?php echo $data->getTutorDetail($data->ref_account_id); ?>
	</td>
	<td>
		<?php 
		if(!empty($subject) && isset($subject))
			echo Common::formatCurrency($data->tutorSubjectRate($data->ref_account_id, $subject));
		else 
			echo Common::formatCurrency($data->default_hourly_rate);
		?>
	</td>
</tr>