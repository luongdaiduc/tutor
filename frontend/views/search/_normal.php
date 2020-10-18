<?php 
	$shortlist_ids = isset(Yii::app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
	$checked_row = in_array($model->id, explode(',', $shortlist_ids));
?>
<tr>
	<td class="short-list"><input style="margin-bottom: 15px; margin-right: 5px" value="<?php echo $model->id?>" type="checkbox" title="Add to Shortlist" class="select-on-check" <?php echo $checked_row ? 'checked' : ''?> ></td>
	<td><a href="<?php echo $model->accounts->profileLink($model->ref_account_id)?>" ><?php echo $model->accounts->first_name . ' ' . $model->accounts->last_name;?></a>
	</td>
	<td><?php echo $model->suburb?></td>
	<td>
		<?php 
			if(!empty($subject) && isset($subject))
				echo Common::formatCurrency($model->tutorSubjectRate($model->ref_account_id, $subject));
			else 
				echo Common::formatCurrency($model->default_hourly_rate);
		?>
	</td>
	<td><?php echo $model->accounts->allSubjects?></td>
</tr>
