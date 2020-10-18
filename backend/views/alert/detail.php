<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/alert')?>">Alerts</a> <span class="divider">/</span>
			</li>
			<li class="active">Detail</li>
		</ul>
	</div>
	
	<div id="content_show">
	<?php $this->renderPartial('_detail', array('error'=>$error))?>
	</div>
	
	<hr />

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="m-btn input-medium step_button" id="prev" rel="/alert/detail" value="<?php echo $prev?>" <?php echo empty($prev) ? 'style="display:none"' : "";?> >
				<i class="m-icon-swapleft"></i> Previous
			</button>
			<button type="submit" class="m-btn input-medium step_button" id="next" rel="/alert/detail" value="<?php echo $next?>" <?php echo empty($next) ? 'style="display:none"' : "";?> >
				Next <i class="m-icon-swapright"></i>
			</button>
		</div>
	</div>


</div>
<!--/span-->
