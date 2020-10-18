<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('account', 'Subjects')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php 
				$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'subject-grid',
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
										'header'=>Common::translate('account', 'Subject'),
										'type'=>'raw',
										'value'=>'CHtml::link($data->subjects->name, url("/tutor/subject", array("id"=>$data->id)))',
								),
								array(
										'header'=>Common::translate('account', 'Experience'),
										'value'=>'$data->experience > 1 ? $data->experience . " years" : $data->experience . " year"',
								),
								array(
										'header'=>Common::translate('account', 'Level'),
										'value'=>'!empty($data->subject_levels->name) ? $data->subject_levels->name : ""',
								),
								array(
										'header'=>Common::translate('account', 'Status'),
										'value'=>'$data->status == TutorSubject::ACTIVE ? "Active" : "Disable"',
								),
						),
				));
			?>
            <div>
              	<div class="m-btn-group">
	              	<?php if($dataProvider->totalItemCount > 0) {?>
						<a class="m-btn"><?php echo Common::translate('account', 'With Selected')?></a>
					  	<a class="m-btn btn-rnd-right dropdown-carrettoggle" data-toggle="dropdown" href="#">
					  		<span class="caret"></span>
					  	</a>
					  	<ul class="m-dropdown-menu">
					      	<li><a href="#" onclick = "return manageMultiRecord('/tutor/manageMultiRecord', 'delete', 'subject-grid');" ><?php echo Common::translate('account', 'Delete')?></a></li>
					      	<li><a href="#" onclick = "return manageMultiRecord('/tutor/manageMultiRecord', 'enable', 'subject-grid');" ><?php echo Common::translate('account', 'Enable')?></a></li>
					      	<li><a href="#" onclick = "return manageMultiRecord('/tutor/manageMultiRecord', 'disable', 'subject-grid');" ><?php echo Common::translate('account', 'Disable')?></a></li>
					  	</ul>
					<?php }?>
				
			  		<a class="m-btn input-medium" href="<?php echo url('/tutor/subject')?>"><?php echo Common::translate('account', 'Add Subject')?> <i class="icon-share-alt"></i></a>
				</div>
			</div>
				
		</div>
	</div>

</div>
<!--/span-->
