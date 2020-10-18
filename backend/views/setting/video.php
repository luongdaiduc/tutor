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
					<label class="control-label" for="inputEmail">Enabled</label>
					<div class="controls">
						<input type="checkbox" placeholder="" <?php echo $video_enable->value == 1 ? 'checked' : ''?> name="video_enable" >
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Player Width</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Player Width" value="<?php echo $video_player_width->value?>" name="video_player_width">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Player Length</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Player Length" value="<?php echo $video_player_length->value?>" name="video_player_length">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Summary Minimum</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Summary Minimum " value="<?php echo $video_summary_minimum->value?>" name="video_summary_minimum">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Summary Maximum</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Summary Maximum" value="<?php echo $video_summary_maximum->value?>" name="video_summary_maximum">
					</div>
				</div>
			
				<button type="submit" class="m-btn input-medium">
					Save <i class="m-icon-swapright"></i>
				</button>
				
			</div>
		</div>
	</form>
</div>
