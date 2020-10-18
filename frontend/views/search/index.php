<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('search', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('search', 'Advanced Search')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<form class="form-horizontal" action="<?php echo url('/search/result')?>" method="get">
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php echo Common::translate('search', 'Subject')?></label>
					<div class="controls">
						<?php echo CHtml::dropDownList('subject', '', $this->subjects, array('class'=>'input-xlarge', 'empty'=>Common::translate('search', 'Choose Subject')))?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('search', 'Location')?></label>
					<div class="controls controls-row">
						<input class="input-xlarge" id="post_code" type="text" placeholder="<?php echo Common::translate('search', 'Postcode')?>" name="post_code" /> 
						<?php echo CHtml::dropDownList('search_km', '', Common::getSearchKmChoices($this->settings['search_km_choices']), array('class'=>'input-medium'))?>
						
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('search', 'Level')?></label>
					<div class="controls">
						<?php echo CHtml::dropDownList('level', '', $this->levels, array('empty'=>Common::translate('search', 'Any')))?>
					</div>
				</div>
	
				<div class="control-group">
					<label class="control-label" for=""><?php echo Common::translate('search', 'Delivery')?></label>
					<div class="controls">
						<?php $deliveries = $this->deliveries;?>
						<?php foreach ($deliveries as $idx => $delivery) {?>
							<label class="checkbox inline"> 
								<input type="checkbox" name="deliveries[]" id="" value="<?php echo $idx;?>" ><?php echo $delivery;?>
							</label>
						<?php }?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="optionsRadios"><?php echo Common::translate('search', 'Gender')?></label>
					<div class="controls">
						<label class="checkbox inline gender"> <input type="checkbox" name="" id="male" value="Male" checked><?php echo Common::translate('search', 'Male')?>
						</label> 
						<label class="checkbox inline gender"> <input type="checkbox" name="" id="female" value="Female" checked><?php echo Common::translate('search', 'Female')?>
						</label> 
					</div>
					<input type="hidden" id="gender" name="gender" value="Any">
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('search', 'Experience')?></label>
					<div class="controls">
						<label id="experience_value" style="border: 0; display: inline;" class="input-small"><?php echo $this->selected['min_experience'] . '-' . $this->selected['max_experience']?></label>
						<label style="border: 0; display: inline;" class="input-small"><?php echo Common::translate('search', 'Years')?></label>
						<div id="experience_slider" class="input-xlarge"></div>
						
						<input id="min_experience" size="16" type="hidden" name="min_experience">
						<input id="max_experience" size="16" type="hidden" name="max_experience">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('search', 'Hourly Rate')?></label>
					<div class="controls">
						<label id="rate_value" style="border: 0; display: inline;" class="input-mini"><?php echo $this->selected['min_rate'] . '-' . $this->selected['max_rate']?></label>
			   		 	<label style="border: 0; display: inline;" class="input-mini"><?php echo $this->settings['currency']?></label>
						<div id="rate_slider" class="input-xlarge"></div>
					
						<input id="min_rate" size="16" type="hidden" name="min_rate">
						<input id="max_rate" size="16" type="hidden" name="max_rate">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('search', 'Feedback')?></label>
					<div class="controls">
						<?php echo CHtml::dropDownList('search_feedback', '', Common::getSearchFeedbackChoices($this->settings['search_feedback_choices']), array('class'=>'span2'))?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('search', 'Review')?></label>
					<div class="controls">
						<label id="star_value" style="border: 0; display: inline;" class="input-mini"><?php echo '1-5'?></label>
			   		 	<label style="border: 0; display: inline;" class="input-mini"><?php echo Common::translate('search', 'Stars')?></label>
						<div id="star_slider" class="input-xlarge"></div>
					
						<input id="min_star" size="16" type="hidden" name="min_star">
						<input id="max_star" size="16" type="hidden" name="max_star">
						
						<?php //echo CHtml::dropDownList('search_review', '', Common::getSearchReviewChoices($this->settings['search_review_choices']), array('class'=>'span2'))?>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="reset" class="m-btn span2" onclick="javascript: window.location.reload();"><?php echo Common::translate('search', 'Reset')?></button>
						<button type="submit" class="m-btn span2"><?php echo Common::translate('search', 'Submit')?> &#187;</button>
					</div>
				</div>
			</form>

		</div>
	</div>

</div>

<script type="text/javascript">

//rate slider
$("#rate_slider").slider({
    range: true,
    min: <?php echo $this->selected['min_rate']?>,
    max: <?php echo $this->selected['max_rate']?>,
    values: [<?php echo $this->selected['min_rate'] . ',' . $this->selected['max_rate']?>],
    slide: function (event, ui) {
    	$("#rate_value").html(ui.values[0] + '-' + ui.values[1]);
        $("#min_rate").val(ui.values[0]);
        $("#max_rate").val(ui.values[1]);
    }
});

$("#min_rate").val(<?php echo $this->selected['min_rate'];?>);
$("#max_rate").val(<?php echo $this->selected['max_rate'];?>);

//experience slider
$("#experience_slider").slider({
    range: true,
    min: <?php echo $this->selected['min_experience']?>,
    max: <?php echo $this->selected['max_experience']?>,
    values: [<?php echo $this->selected['min_experience'] . ',' . $this->selected['max_experience']?>],
    slide: function (event, ui) {
        $("#experience_value").html(ui.values[0] + '-' + ui.values[1]);
        $("#min_experience").val(ui.values[0]);
        $("#max_experience").val(ui.values[1]);
    }
});

$("#min_experience").val(<?php echo $this->selected['min_experience'];?>);
$("#max_experience").val(<?php echo $this->selected['max_experience'];?>);

//star slider
$("#star_slider").slider({
  range: true,
  min: 1,
  max: 5,
  values: [1,5],
  slide: function (event, ui) {
      $("#star_value").html(ui.values[0] + '-' + ui.values[1]);
      $("#min_star").val(ui.values[0]);
      $("#max_star").val(ui.values[1]);
  }
});

$("#min_star").val(1);
$("#max_star").val(5);
</script>