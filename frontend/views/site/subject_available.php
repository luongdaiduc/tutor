<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('content', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/search')?>"><?php echo Common::translate('content', 'Search')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('content', 'Subjects Available')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php $this->renderPartial('_block', array('page'=>$page))?>
			
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

</div>
<!--/span-->
