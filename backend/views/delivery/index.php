<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Deliveries</li>
		</ul>
	</div>
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
			
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'delivery-grid',
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
								'value'=>'CHtml::link($data->name, url("/delivery/edit", array("id"=>$data->id)))',
						),
						array(
								'header'=>'Created',
								'value'=>'date("d M Y", strtotime($data->created))',
						),
						
						array(
								'header'=>'Status',
								'value'=>'$data->status == 0 ? "Disable" : "Active"',
						),
						
				),
		));
	?>
	
	<?php if($dataProvider->totalItemCount > 0) {?>
		<div class="m-btn-group">
			<a class="m-btn">With Selected</a> <a class="m-btn dropdown-carrettoggle" data-toggle="dropdown" href="#"> <span class="caret"></span> </a>
			<ul class="m-dropdown-menu">
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/delivery/manageMultiRecord')?>', 'delete', 'delivery-grid');" ><i class="icon-trash"></i> Delete</a>
				</li>
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/delivery/manageMultiRecord')?>', 'publish', 'delivery-grid');" ><i class="icon-play-circle"></i> Active</a>
				</li>
				<li><a href="#" onclick="return manageMultiRecord('<?php echo url('/delivery/manageMultiRecord')?>', 'draft', 'delivery-grid');" ><i class="icon-ban-circle"></i> Disable</a>
				</li>
			</ul>
		</div>
	<?php }?>
	
	<div class="m-btn-group">
		<a href="<?php echo url('/delivery/edit')?>" class="m-btn input-medium">Create <i class="m-icon-swapright"></i>
		</a>
	</div>

</div>
<!--/span-->
