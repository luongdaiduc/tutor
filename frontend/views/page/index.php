<div class="span10">
	<?php if(!empty($model)) {?>
		<div>
			<ul class="breadcrumb">
				<li><a href="/"><?php echo Common::translate('content', 'Home')?></a> <span class="divider">/</span>
				</li>
				<li class="active"><?php echo $model->title?></li>
			</ul>
		</div>
	
		<div class="page-header">
			<h1>
				<?php echo $model->title;?>
			</h1>
		</div>
	
		<?php echo $model->body?>
		
		<?php
			if(!empty($model->blocks)) 
			{
				foreach ($model->blocks as $block)
				{
					if($block->status == Block::PUBLISHED)
					{
						$this->beginWidget('zii.widgets.CPortlet', array('titleCssClass'=>'title_block', 'title'=>$block->name, 'htmlOptions'=>array('class'=>'block')));
						echo $block->body;
						$this->endWidget();
					}
				}
			}
		?>
	<?php } else { echo 'The request page doesn\'t exist.'; }?>

	
</div>
<!--/span-->
