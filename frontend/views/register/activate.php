<div class="span10">
	<?php if(isset($message) && !empty($message)) {?>
	<p class="alert alert-success"><?php echo $message?></p>
	<a href="<?php echo url('/site/login')?>">Click here to login</a>
	<?php } else {?>
	<p>Activate account failed.</p>
	<?php }?>

</div>