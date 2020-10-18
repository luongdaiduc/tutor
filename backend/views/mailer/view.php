<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/mailer/queue')?>">Queues</a> <span class="divider">/</span>
			</li>
			<li class="active">Mail Detail</li>
		</ul>
	</div>
	
	<div id="content_show">
	<?php $this->renderPartial('_view', array('model'=>$model))?>
	</div>
	
	<hr />

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="m-btn input-medium step_button" id="prev" rel="<?php echo url('/mailer/viewQueue')?>" value="<?php echo $prev?>" <?php echo empty($prev) ? 'style="display:none"' : "";?> >
				<i class="m-icon-swapleft"></i> Previous
			</button>
			<button type="submit" class="m-btn input-medium step_button" id="next" rel="<?php echo url('/mailer/viewQueue')?>" value="<?php echo $next?>" <?php echo empty($next) ? 'style="display:none"' : "";?> >
				Next <i class="m-icon-swapright"></i>
			</button>
			<button type="submit" class="m-btn input-medium" id="send_queue">
			Send <i class="m-icon-swapright"></i>
			</button>
		</div>
	</div>

</div>
<!--/span-->
