<h2>
	<?php echo $error->level?>
</h2>
<h4>
	<?php echo $error->title?>
</h4>
<h5>
	<?php echo date('d M Y H:i', strtotime($error->created))?>
</h5>
<hr />

<?php echo $error->source?>
