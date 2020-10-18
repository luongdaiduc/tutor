<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('content', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('home', 'Contact')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php $this->renderPartial('_block', array('page'=>$page))?>
			
			<?php $this->renderPartial('_form', array('model'=>$model, 'message'=>$message))?>
				
		</div>
	</div>

</div>
<!--/span-->
