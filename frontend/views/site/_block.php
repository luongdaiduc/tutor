<?php 
	if(!empty($page) && !empty($page->blocks))
	{
		foreach ($page->blocks as $block)
		{
			if($block->status == Block::PUBLISHED)
			{
				$this->beginWidget('zii.widgets.CPortlet', array('htmlOptions'=>array('class'=>'')));
				echo $block->body;
				$this->endWidget();
			}
		}
	}
?>