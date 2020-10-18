<h2>
	<?php echo $message->title?>
</h2>
<h4>
	<?php echo $message->sender_name . '( ' . $message->sender_email . ')'?>
</h4>
<h5>
	<?php echo date('d M Y H:i', strtotime($message->created))?>
</h5>
<hr />

<?php echo $message->content?>
