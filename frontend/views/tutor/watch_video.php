<?php if($this->settings['video_enable'] == 1) {?>
	<div class="span10">
		<div>
			<ul class="breadcrumb">
				<li><a href="/">Home</a> <span class="divider">/</span>
				</li>
				<li><a href="<?php echo url('/search/index')?>">Tutors</a> <span class="divider">/</span>
				</li>
				<li><a href="">Melbourne</a> <span class="divider">/</span>
				</li>
				<li><a href="<?php echo Account::profileLink($account->id)?>"><?php echo $account->first_name . ' ' . $account->last_name?></a> <span class="divider">/</span>
				</li>
				<li class="active">View Video</li>
			</ul>
		</div>
	
		<div class="row-fluid">
			<div class="span12">
	
				<h3><?php echo $video->title?></h3>
	
				<iframe width="<?php echo $this->settings['video_player_width']?>" height="<?php echo $this->settings['video_player_length']?>"
					src="<?php echo $embed_link?>" frameborder="0" allowfullscreen></iframe>
	
				<p><?php echo $video->description?></p>
	
	
			</div>
		</div>
	
	
	
	</div>
	<!--/span-->
<?php }?>
