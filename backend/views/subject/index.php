<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span></li>
			<li>Subjects</li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			
				<p class="alert-success" style="<?php echo isset($message) ? '' : 'display:none'?>" ><?php echo $message;?></p>
			
			
			<?php 
				$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'subject-grid',
						'dataProvider'=>$dataProvider,
						'selectableRows'=>'2',
						'template'=>'{items}{pager}',
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
										'header'=>'Subject',
										'type'=>'raw',
										'value'=>'CHtml::link($data->name, url("/subject/edit", array("id"=>$data->id)))',
								),
								array(
										'header'=>'Parent Subject',
										'value'=>'$data->getParentName()',
								),
								array(
										'header'=>'Status',
										'value'=>'$data->status == Subject::ACTIVE ? "Active" : "Disabled"',
								),
								array(
										'header'=>'#Tutors',
										'value'=>'$data->countTutor()',
								),
						),
				));
			?>
			
				<div>
					<div class="m-btn-group">
					<?php if($dataProvider->totalItemCount > 0) {?>
						<a class="m-btn">With Selected</a> 
						<a class="m-btn btn-rnd-right dropdown-carrettoggle" data-toggle="dropdown" href="#"> <span class="caret"></span></a>
						<ul class="m-dropdown-menu">
<!-- 						<li><a href="#">Edit</a></li> -->
							<li><a href="#" rel="delete" onclick="return manageMultiRecord('<?php echo url('/subject/manageMultiRecord')?>', 'delete', 'subject-grid');" ><i class="icon-trash"></i> Delete</a></li>
							<li><a href="#" rel="disable" onclick="return manageMultiRecord('<?php echo url('/subject/manageMultiRecord')?>', 'disable', 'subject-grid');" ><i class="icon-ban-circle"></i> Disable</a></li>
							<li><a href="#" rel="enable" onclick="return manageMultiRecord('<?php echo url('/subject/manageMultiRecord')?>', 'enable', 'subject-grid');" ><i class="icon-play-circle"></i> Enable</a></li>
						</ul>
					<?php }?>
						<a class="m-btn input-medium" href="<?php echo url('/subject/edit')?>">Add Subject <i class="icon-share-alt"></i></a>
					</div>
				</div>
			
		</div>

	</div>
</div>
