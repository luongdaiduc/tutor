<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Pages</li>
		</ul>
	</div>
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
			
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'page-grid',
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
								'header'=>'Name',
								'type'=>'raw',
								'value'=>'CHtml::link($data->title, url("/page/edit", array("id"=>$data->id)))',
						),
						array(
								'header'=>'Created',
								'value'=>'date("d M Y", strtotime($data->created))',
						),
						array(
								'header'=>'Modified',
								'value'=>'!empty($data->updated) ? date("d M Y", strtotime($data->updated)) : ""',
						),
						array(
								'header'=>'Published',
								'value'=>'$data->status == 0 ? "Draft" : "Published"',
						),
						
				),
		));
	?>
	
	<?php if($dataProvider->totalItemCount > 0) {?>
		<div class="m-btn-group">
			<a class="m-btn">With Selected</a> <a class="m-btn dropdown-carrettoggle" data-toggle="dropdown" href="#"> <span class="caret"></span> </a>
			<ul class="m-dropdown-menu">
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/page/manageMultiRecord')?>', 'delete', 'page-grid');" ><i class="icon-trash"></i> Delete</a>
				</li>
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/page/manageMultiRecord')?>', 'publish', 'page-grid');" ><i class="icon-play-circle"></i> Publish</a>
				</li>
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/page/manageMultiRecord')?>', 'draft', 'page-grid');" ><i class="icon-ban-circle"></i> Draft</a>
				</li>
			</ul>
		</div>
	<?php }?>
	<div class="m-btn-group">
		<a href="<?php echo url('/page/edit')?>" class="m-btn input-medium">Create <i class="m-icon-swapright"></i>
		</a>
	</div>

</div>
<!--/span-->
