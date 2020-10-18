<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Subscriptions</li>
		</ul>
	</div>

<!-- 	<form class="form-horizontal"> -->
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputName">Active</label> -->
<!-- 			<div class="controls"> -->
<!-- 				<input type="checkbox"> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputName">Test Mode</label> -->
<!-- 			<div class="controls"> -->
<!-- 				<input type="checkbox"> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputEmail">Name</label> -->
<!-- 			<div class="controls"> -->
<!-- 				<input class="input-xlarge" type="text" placeholder="Company Name"> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputEmail">E-mail</label> -->
<!-- 			<div class="controls"> -->
<!-- 				<input class="input-xlarge" type="text" placeholder="E-mail"> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputEmail">Return Url</label> -->
<!-- 			<div class="controls"> -->
<!-- 				<input class="input-xlarge" type="text" placeholder="Retrurn Url"> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="control-group"> -->
<!-- 			<label class="control-label" for="inputName">Currency</label> -->
<!-- 			<div class="controls"> -->
<!-- 				<select class="input-small"> -->
<!-- 					<option>GBP</option> -->
<!-- 					<option>USD</option> -->
<!-- 				</select> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 	</form> -->

	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
	
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'subscription-grid',
				'dataProvider'=>$dataProvider,
				'template'=>'{items}{pager}',
				'selectableRows'=>2,
				'itemsCssClass'=>'table table-striped table-hover table-condensed',
				'pagerCssClass'=>'pagination pagination-centered',
				'pager'=>array(
						'class'=>'CustomPager',
						'header'=>'',
						'prevPageLabel'=>'Prev',
						'nextPageLabel'=>'Next',
				),
				'columns'=>array(
						array(
								'class'=>'CCheckBoxColumn',
						),
						array(
								'header'=>'Title',
								'type'=>'raw',
								'value'=>'CHtml::link($data->title, url("/subscription/edit", array("id"=>$data->id)))',
						),
						array(
								'header'=>'Type',
								'value'=>'$data->type == Subscription::ENHANCE ? "Enhanced" : "Premium"',	
						),
						array(
								'header'=>'Period',
								'value'=>'$data->period',			
						),
						array(
								'header'=>'Amount',
								'value'=>'Common::formatCurrency($data->amount)',
						),
						array(
								'header'=>'Published',
								'value'=>'$data->status == Subscription::PUBLISHED ? "Published" : "Draft"',
						),
				),
		));
	?>
	
	<?php if($dataProvider->totalItemCount > 0) {?>
		<div class="m-btn-group">
			<a class="m-btn">With Selected</a> <a class="m-btn dropdown-carrettoggle" data-toggle="dropdown" href="#"> <span class="caret"></span> </a>
			<ul class="m-dropdown-menu">
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/subscription/manageMultiRecord')?>', 'delete', 'subscription-grid');" ><i class="icon-trash"></i> Delete</a>
				</li>
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/subscription/manageMultiRecord')?>', 'publish', 'subscription-grid');" ><i class="icon-play-circle"></i> Publish</a>
				</li>
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/subscription/manageMultiRecord')?>', 'draft', 'subscription-grid');" ><i class="icon-ban-circle"></i> Draft</a>
				</li>
			</ul>
		</div>
	<?php }?>
	
	<div class="m-btn-group">
		<a href="<?php echo url('/subscription/edit')?>" class="m-btn input-medium">Create <i class="m-icon-swapright"></i>
		</a>
	</div>


</div>
<!--/span-->
