<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $data->category?>" href="#collapseG<?php echo $data->id?>"> <!-- Title with experience details. -->
			<h4>
				<?php echo $data->title?>
			</h4>
		</a>
	</div>
	<div id="collapseG<?php echo $data->id?>" class="accordion-body collapse" style="height: 0px;">
		<div class="accordion-inner">
			<p>
				<?php echo $data->content?>
			</p>
		</div>
	</div>
</div>