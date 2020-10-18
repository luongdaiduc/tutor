<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('content', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('content', 'Sitemap')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<h3><?php echo Common::translate('content', 'Available Subjects')?></h3>

			<ul>
				<?php 
					if(!empty($subjects))
					{
						foreach ($subjects as $subject)
						{
				?>			
							<li class="<?php echo $subject->level > 1 ? 'level-child' : ''?>" style="margin-left: <?php echo 20*($subject->level - 1) . 'px'?>;"><a href="<?php echo url('/search/result', array('subject'=>$subject->name))?>"><?php echo $subject->name?></a></li>
				<?php
						}
					}
				?>
			</ul>

		</div>
	</div>

	<hr />

	<div class="row-fluid">
		<div class="span12">
			<h3><?php echo Common::translate('content', 'Tutor Locations')?></h3>

			<ul>
				<?php 
					if(!empty($suburbs)) 
					{
						foreach ($suburbs as $suburb)
						{
				?>
							<li><a href="<?php echo url('/search/result', array('suburb'=>$suburb->suburb))?>"><?php echo $suburb->suburb?></a>
							</li>
				<?php
						}	
					}
				?>
			</ul>

		</div>
	</div>



</div>
<!--/span-->
