<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span></li>
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
					<label class="control-label" for="inputEmail">Latest Tutors</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Latest Tutors" value="<?php echo $count_latest_tutor->value?>" name="count_latest_tutor">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Search Results</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Search Results" value="<?php echo $count_search_result->value?>" name="count_search_result">
					</div>
				</div>
			
				<div class="control-group">
					<label class="control-label" for="inputEmail">Browse Tutors</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Browse Tutors" value="<?php echo $count_browse_tutor->value?>" name="count_browse_tutor">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Summary Minimum</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Summary Minimum" value="<?php echo $summary_minimum->value?>" name="summary_minimum">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Summary Maximum</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Summary Maximum" value="<?php echo $summary_maximum->value?>" name="summary_maximum">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Description Minimum</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Description Minimum" value="<?php echo $description_minimum->value?>" name="description_minimum">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Description Maximum</label>
					<div class="controls">
						<input class="input-small" type="text" placeholder="Description Maximum" value="<?php echo $description_maximum->value?>" name="description_maximum">
					</div>
				</div>
			
				<button type="submit" class="m-btn input-medium">
					Save <i class="m-icon-swapright"></i>
				</button>
				
			</div>
		</div>
	</form>
</div>
