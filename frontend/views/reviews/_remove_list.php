<blockquote>
	<?php echo $data->showStar($data->rating)?>
	<div style="clear: both;"></div>
	<p>
		<?php echo $data->content?>
	</p>
	<small><?php echo $data->post_by . ' ' . date('d F Y', strtotime($data->created))?>
	</small>
</blockquote>
