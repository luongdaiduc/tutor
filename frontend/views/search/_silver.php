<!--======= Start Silver f9f9f9 ======-->

<div class="silver">

	<div class="row-fluid">
		<div class="span12">

			<div class="row-fluid">
				<div class="span9">
					<h4 style="line-height: 25px; margin: 0px; display: inline-block;">
						<?php 
								$shortlist_ids = isset(Yii::app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
								$checked_row = in_array($model->id, explode(',', $shortlist_ids));
						?>
								<span class="short-list"><input style="margin-bottom: 15px; margin-right: 5px" value="<?php echo $model->id?>" type="checkbox" title="Add to Shortlist" class="select-on-check" <?php echo $checked_row ? 'checked' : ''?> ></span>

						<a href="<?php echo $model->accounts->profileLink($model->ref_account_id)?>" ><?php echo $model->accounts->first_name . ' ' . $model->accounts->last_name;?></a>
					</h4>
				</div>
				<div class="span3">
					<div class="pull-right">
						<?php echo $model->showRatingStar($model->accounts->id)?>
					</div>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<ul class="inline unstyled">
						<li style="padding-left: 0px">
							<strong><?php echo Common::translate('search', 'From')?>:</strong> 
							<?php 
								if(!empty($subject) && isset($subject))
									echo Common::formatCurrency($model->tutorSubjectRate($model->ref_account_id, $subject));
								else 
									echo Common::formatCurrency($model->default_hourly_rate);
							?>
						</li>
						<?php if(!empty($model->phone)) {?>
							|
							<li><strong><?php echo Common::translate('profile', 'Phone')?>:</strong> <?php echo $model->phone?></li>
						<?php }?>
						|
						<li><strong><?php echo Common::translate('profile', 'Location')?>:</strong> <?php echo $model->suburb?></li>
					</ul>
				</div>
			</div>
			
			<div class="row-fluid">
				<div class="span12"><?php echo $model->accounts->advertises->summary?></div>
			</div>

		</div>
		<!--/span-->
	</div>
	<!--/row-->
</div>
<!--======= End Silver =========-->
