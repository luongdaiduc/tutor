<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">State</li>
		</ul>
	</div>
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
			
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'state-grid',
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
								'header'=>'State',
								'type'=>'raw',
								'value'=>'CHtml::link($data->state, url("/state/edit", array("id"=>$data->id)))',
						),
						array(
								'header'=>'Default',
								'type'=>'raw',
								'value'=>'$data->is_default == 1 ? CHtml::image(app()->params["siteUrl"] . "/theme/img/star.jpg") : ""',
						),
						array(
								'header'=>'Created',
								'value'=>'date("d M Y", strtotime($data->created))',
						),
				),
		));
	?>
	
	<?php if($dataProvider->totalItemCount > 0) {?>
		<div class="m-btn-group">
			<a class="m-btn">With Selected</a> <a class="m-btn dropdown-carrettoggle" data-toggle="dropdown" href="#"> <span class="caret"></span> </a>
			<ul class="m-dropdown-menu">
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/state/manageMultiRecord')?>', 'delete', 'state-grid');" ><i class="icon-trash"></i> Delete</a>
				</li>
			</ul>
		</div>
	<?php }?>
	<div class="m-btn-group">
		<a href="<?php echo url('/state/edit')?>" class="m-btn input-medium">Create <i class="m-icon-swapright"></i>
		</a>
	</div>

</div>
<!--/span-->
