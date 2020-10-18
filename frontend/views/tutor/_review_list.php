<?php 
	$active_star = $data->rating;
	$inactive_star = 5 - $data->rating;
?>
<blockquote>
	<?php for($i=1; $i<=$active_star; $i++) {?>
	<div class="active_star"></div>
	<?php }?>
	<?php for($i=1; $i<=$inactive_star; $i++) {?>
	<div class="inactive_star"></div>
	<?php }?>
	<div style="clear: both;"></div>
	<p><?php echo $data->content?></p>
	<small><?php echo $data->post_by . ' ' . date('d F Y', strtotime($data->created))?></small>
</blockquote>
