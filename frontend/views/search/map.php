<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('register', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/search')?>"><?php echo Common::translate('search', 'Tutors')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('search', 'Home')?>Map</li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<div id="alert_message" style="display: none"><?php echo Common::translate('search', 'No result found')?></div>
			
			<br />
			<br />
			
			<div>
				<img src="<?php echo app()->baseUrl?>/theme/img/loading.gif" id="loading_image" style="display: none;"/>
				<div id="map_canvas" style="width: 100%; height: 600px;"></div> 
			</div>
			
			<br />
			<br />
			<br />
			
		</div>
	</div>

</div>


<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
	GMap.summaries = <?php echo $summaries?>;
    GMap.titles = <?php echo $titles?>;
	GMap.latlngs = <?php echo $latlngs?>;
        
	google.maps.event.addDomListener(window, 'load', GMap.initialize());
</script>

