<div class="span2">
<?php 
	$not_fill = app()->controller->action->id == 'map' || app()->controller->action->id == 'browse';
	$is_map = app()->controller->action->id == 'map';
?>
	<form action="<?php echo url('/search/result')?>" method="get" id="asearch_form">
		<ul class="nav nav-list tutor-nav-list">
			<li class="nav-header"><?php echo Common::translate('search', 'Subject')?></li>
			<li><?php echo CHtml::dropDownList('subject', (isset($this->selected['subject']) && !empty($this->selected['subject'])) ? $this->selected['subject'] : '', $this->subjects, array('class'=>'span12', 'empty'=>Common::translate('search', 'Choose Subject')))?>
			</li>
			<li class="nav-header"><?php echo Common::translate('search', 'Location')?></li>
			<li><input type="text" placeholder="<?php echo Common::translate('search', 'Postcode')?>" class="span12" name="post_code" value="<?php echo !$not_fill ? $this->selected['postcode'] : ''?>"/>
			</li>
			<li>
				<?php echo CHtml::dropDownList('search_km', !$not_fill ? $this->selected['km'] : '', Common::getSearchKmChoices($this->settings['search_km_choices']), array('class'=>'span12'))?>
			</li>

			<li class="nav-header"><?php echo Common::translate('search', 'Level')?></li>
			<li>
				<?php echo CHtml::dropDownList('level', !$not_fill ? $this->selected['level'] : '', $this->levels, array('class'=>'span12', 'empty'=>Common::translate('search', 'Any')))?>
			</li>

			<li class="nav-header"><?php echo Common::translate('search', 'Delivery')?></li>
			<li>
				<?php $deliveries = $this->deliveries;?>
				<?php foreach ($deliveries as $idx => $delivery) {?>
					<label class="checkbox"> 
						<input type="checkbox" name="deliveries[]" id="" value="<?php echo $idx;?>" <?php echo !$not_fill ? (in_array($idx, $this->selected['deliveries']) ? 'checked' : '') : ''?> ><?php echo $delivery;?>
					</label>
				<?php }?>
			</li>
			<li class="nav-header"><?php echo Common::translate('search', 'Gender')?></li>
			<li>
				<?php echo CHtml::dropDownList('gender', !$not_fill ? $this->selected['gender'] : '', array('Male'=>Common::translate('search', 'Male'), 'Female'=>Common::translate('search', 'Female')), array('class'=>'span12', 'empty'=>Common::translate('search', 'Any')))?>
			</li>
			<li class="nav-header"><?php echo Common::translate('search', 'Hourly Rate')?></li>
			<li>
				<div class="controls">
					<div class="">
					    <label id="rate_value" style="border: 0; display: inline;" class="input-mini"><?php echo !$not_fill ? $this->selected['selected_min_rate'] . '-' . $this->selected['selected_max_rate'] : $this->selected['min_rate'] . '-' . $this->selected['max_rate']?></label>
					    <label style="border: 0; display: inline;" class="input-mini"><?php echo $this->settings['currency']?></label>
						<div id="rate_slider"></div>
						
						<input id="min_rate" size="16" type="hidden" name="min_rate">
						<input id="max_rate" size="16" type="hidden" name="max_rate">
					</div>
				</div>
			</li>
			<li class="nav-header"><?php echo Common::translate('search', 'Years Experience')?></li>
			<li>
				<div class="controls">
					<div style="">
						<label id="experience_value" style="border: 0; display: inline;" class="input-small"><?php echo !$not_fill ? $this->selected['selected_min_experience'] . '-' . $this->selected['selected_max_experience'] : $this->selected['min_experience'] . '-' . $this->selected['max_experience']?></label>
						<label style="border: 0; display: inline;" class="input-small"><?php echo Common::translate('search', 'Years')?></label>
						<div id="experience_slider"></div>
						
						<input id="min_experience" size="16" type="hidden" name="min_experience">
						<input id="max_experience" size="16" type="hidden" name="max_experience">
					</div>
				</div>
			</li>
			<li>
				<button type="submit" class="m-btn span12" id="asearch_button" style="margin-top: 30px;"><?php echo Common::translate('search', 'Search')?> <i class="icon-search"></i></button>
				<input type="hidden" value="<?php echo $is_map ? '1' : '0';?>" id="is_map"/>
			</li>
		</ul>
	</form>
</div>

<script type="text/javascript">

//rate slider
$("#rate_slider").slider({
    range: true,
    min: <?php echo $this->selected['min_rate']?>,
    max: <?php echo $this->selected['max_rate']?>,
    values: [<?php echo !$not_fill ? $this->selected['selected_min_rate'] . ',' . $this->selected['selected_max_rate'] : $this->selected['min_rate'] . ',' . $this->selected['max_rate']?>],
    slide: function (event, ui) {
    	$("#rate_value").html(ui.values[0] + '-' + ui.values[1]);
        $("#min_rate").val(ui.values[0]);
        $("#max_rate").val(ui.values[1]);
    }
});

$("#min_rate").val(<?php echo !$not_fill ? $this->selected['selected_min_rate'] : $this->selected['min_rate']?>);
$("#max_rate").val(<?php echo !$not_fill ? $this->selected['selected_max_rate'] : $this->selected['max_rate']?>);

//experience slider
$("#experience_slider").slider({
    range: true,
    min: <?php echo $this->selected['min_experience']?>,
    max: <?php echo $this->selected['max_experience']?>,
    values: [<?php echo !$not_fill ? $this->selected['selected_min_experience'] . ',' . $this->selected['selected_max_experience'] : $this->selected['min_experience'] . ',' . $this->selected['max_experience']?>],
    slide: function (event, ui) {
        $("#experience_value").html(ui.values[0] + '-' + ui.values[1]);
        $("#min_experience").val(ui.values[0]);
        $("#max_experience").val(ui.values[1]);
    }
});

$("#min_experience").val(<?php echo !$not_fill ? $this->selected['selected_min_experience'] : $this->selected['min_experience']?>);
$("#max_experience").val(<?php echo !$not_fill ? $this->selected['selected_max_experience'] : $this->selected['max_experience']?>);
</script>