<!--========= Start Gold ========-->
<?php 
	if (!empty($feature)) 
	{
		$avatar = Gallery::model()->getAvatar($feature->id);
?>

		<h2 style="margin-top: 0px"><?php echo Common::translate('home', 'Featured Tutor')?></h2>
		
		<div id="feature_tutor" class="gold">
			<div class="row-fluid">
				<?php if(!empty($avatar)) {?>
					<div class="span3">
						<div style="margin-bottom: 10px">
							<a href="<?php echo Account::profileLink($feature->id)?>"> 
								<img src="<?php echo app()->baseUrl . '/' . Common::getUserImageFolder($feature->id)?>/<?php echo 'thumb-' . $avatar;?> " alt=""  class="img-polaroid">
							</a>
						</div>
					</div>
				<?php }?>
				<div <?php echo !empty($avatar) ? 'class="span9"' : 'class="span12"'?> >
					<h3 style="line-height: 25px; margin: 0px; display: inline;">
						<?php 
							if($this->id == 'search') 
							{
								$shortlist_ids = isset(Yii::app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
								$checked_row = in_array($feature->profiles->id, explode(',', $shortlist_ids));
						?>
								<span class="short-list"><input style="margin-bottom: 15px; margin-right: 5px" value="<?php echo $feature->profiles->id?>" type="checkbox" title="Add to Shortlist" class="select-on-check" <?php echo $checked_row ? 'checked' : ''?> ></span>
						<?php }?>
						<?php echo $feature->first_name . ' ' . $feature->last_name;?>
					</h3>
					<span class="pull-right"> <?php echo $feature->profiles->showRatingStar($feature->id)?> </span>
		
					<div class="row-fluid">
						<div class="span12">
							<ul class="inline unstyled">
								<li style="padding-left: 0px">
									<strong><?php echo Common::translate('search', 'From')?>:</strong> 
									<?php 
										if(!empty($subject) && isset($subject))
											echo Common::formatCurrency($feature->profiles->tutorSubjectRate($feature->id, $subject));
										else 
											echo Common::formatCurrency($feature->profiles->default_hourly_rate);
									?>
								</li>
								<?php if(!empty($feature->profiles->phone)) {?>
									|
									<li><strong><?php echo Common::translate('profile', 'Phone')?>:</strong> <?php echo $feature->profiles->phone?></li>
								<?php }?>
								|
								<li><strong><?php echo Common::translate('profile', 'Location')?>:</strong> <?php echo $feature->profiles->suburb?></li>
							</ul>
						</div>
					</div>
		
					<?php 
						$tutor_subjects = $feature->tutor_subjects;
						
						if(!empty($tutor_subjects))
						{
							$count = count($tutor_subjects);
					?>
							<div class="row-fluid">
								<div class="span12">
									<ul class="inline unstyled">
										<?php 
											foreach ($tutor_subjects as $idx => $tutor_subject)
											{
												if($tutor_subject->status == TutorSubject::ACTIVE)
												{
													$style = $idx == 0 ? 'style="padding-left: 0px"' : '';
													$separate = ($idx + 1) == $count ? '' : '|';
													echo '<li ' . $style . '>' . $tutor_subject->subjects->name . '</li>' . $separate;
												}
											}
										?>
					
									</ul>
								</div>
							</div>
					<?php }?>
					
					<div class="row-fluid">
						<div class="span12"><?php echo $feature->advertises->summary;?></div>
					</div>
		
					<div class="row-fluid">
						<div class="span12">
							<div style="margin-bottom: 10px">
								<a class="m-btn green" href="<?php echo Account::profileLink($feature->id)?>"><?php echo Common::translate('home', 'View details')?> <i class="m-icon-swapright"></i>
								</a>
							</div>
						</div>
					</div>
		
				</div>
			</div>
			<!--/span-->
		</div>
<?php }?>
<!--======== End Gold ===========-->


<?php 
// 	if (!empty($feature)) {
// 		$avatar = Gallery::model()->getAvatar($feature->id);
// ?>
<!-- 	<h2><?php //echo Common::translate('home', 'Featured Tutor')?></h2>
	
<!-- 	<div class="row-fluid"> -->
		<?php //if($avatar != null) {?>
<!-- 			<div class="span3"> -->
<!-- 				<a href="<?php //echo Account::profileLink($feature->id)?>" class="thumbnail"> 
					<img src="<?php //echo app()->baseUrl . '/' . Common::getUserImageFolder($feature->id)?>/<?php //echo 'thumb-' . $avatar;?> " alt="">
<!-- 				</a> -->
<!-- 			</div> -->
		<?php //}?>
		<div <?php //echo $avatar != null ? 'class="span9"' : 'class="span12"'?> >
<!-- 			<table> -->
<!-- 				<tr> -->
					<td><h3><?php //echo $feature->first_name . ' ' . $feature->last_name;?></h3></td>
					<?php 
// 						if($this->id == 'search') 
// 						{
// 							$shortlist_ids = isset(Yii::app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
// 							$checked_row = in_array($feature->profiles->id, explode(',', $shortlist_ids));
// 					?>
							<!-- td class="short-list"><input style="margin-bottom: 5px; margin-left: 5px" value="<?php //echo $feature->profiles->id?>" type="checkbox" title="Add to Shortlist" class="select-on-check" <?php //echo $checked_row ? 'checked' : ''?>></td -->
					<?php //}?>
<!-- 				</tr> -->
<!-- 			</table> -->
	
<!-- 			<p> -->
				<?php //echo $feature->advertises->summary;?>
<!-- 			</p> -->
<!-- 			<p> -->
<!-- 				<a class="m-btn" href="<?php //echo Account::profileLink($feature->id)?>"><?php //echo Common::translate('home', 'View details')?> <i class="m-icon-swapright"></i>
<!-- 				</a> -->
<!-- 			</p> -->
<!-- 		</div> -->
		<!--/span-->
<!-- 	</div> -->
	<!--/row-->
<?php 
// }
?>