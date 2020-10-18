<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Settings</li>
		</ul>
	</div>

	<?php $this->renderPartial('/setting/_menu')?>

	<form class="form-horizontal" method="POST">
		<div class="tab-content">
				
			<div class="" id="">
				<?php if (isset($message)):?>
					<p class="alert-success"><?php echo $message;?></p>
				<?php endif;?>
	
				<div class="control-group">
					<label class="control-label" for="inputEmail">Mail Server</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Mail Server" value="<?php echo $mail_server->value?>" name="mail_server">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Username</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Username" value="<?php echo $username->value?>" name="username">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Password</label>
					<div class="controls">
						<input class="input-xlarge" type="password" placeholder="Password" value="<?php echo $password->value?>" name="password">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Port</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Port" value="<?php echo $port->value?>" name="port">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">SSL</label>
					<div class="controls">
						<input type="checkbox" placeholder="Short Date Format" <?php echo $ssl->value == 1 ? 'checked' : ''?> name="ssl">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">No Reply Name</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="No Reply Name" value="<?php echo $no_reply_name->value?>" name="no_reply_name">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">No Reply Address</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="No Reply Address" value="<?php echo $no_reply_address->value?>" name="no_reply_address">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Reply Name</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Reply Name" value="<?php echo $reply_name->value?>" name="reply_name" id="reply_name">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Reply Address</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Reply Address" value="<?php echo $reply_address->value?>" name="reply_address" id="reply_address">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Notify Expire Before Days</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Notify Expire Silver or Gold Package" value="<?php echo $notify_expire_day->value?>" name="notify_expire_day">
					</div>
				</div>
				
				<button type="submit" class="m-btn input-medium">
					Save <i class="m-icon-swapright"></i>
				</button>
				
				<button type="button" class="m-btn input-medium" id="test_mail">
					Test Mail <i class="m-icon-swapright"></i>
				</button>
				
			</div>
		</div>
	</form>
</div>
