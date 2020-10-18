<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('register', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('register', 'Register')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php $this->renderPartial('_register_header')?>
			
			<p class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo Common::translate('register', 'The activating account link had been sent to your mail. You must activate your account before using')?>.
			</p>
			
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
										'header'=>Common::translate('register', 'Subject'),
										'type'=>'raw',
										'value'=>'CHtml::link($data->subjects->name, url("/register/subject", array("id"=>$data->id)))',
								),
								array(
										'header'=>Common::translate('register', 'Experience'),
										'value'=>'$data->experience > 1 ? $data->experience . " years" : $data->experience . " year"',
								),
								array(
										'header'=>Common::translate('register', 'Level'),
										'value'=>'$data->level',
								),
								array(
										'header'=>Common::translate('register', 'Status'),
										'value'=>'$data->status == TutorSubject::ACTIVE ? "Active" : "Disable"',
								),
						),
				));
			?>
            <div>
              	<div class="m-btn-group">
	              	<?php if($dataProvider->totalItemCount > 0) {?>
						<a class="m-btn">With Selected</a>
					  	<a class="m-btn btn-rnd-right dropdown-carrettoggle" data-toggle="dropdown" href="#">
					  		<span class="caret"></span>
					  	</a>
					  	<ul class="m-dropdown-menu">
					      	<li><a href="#" onclick = "return manageMultiRecord('/register/manageMultiRecord', 'delete', 'subject-grid');" >Delete</a></li>
					      	<li><a href="#" onclick = "return manageMultiRecord('/register/manageMultiRecord', 'enable', 'subject-grid');" >Enable</a></li>
					      	<li><a href="#" onclick = "return manageMultiRecord('/register/manageMultiRecord', 'disable', 'subject-grid');" >Disable</a></li>
					  	</ul>
					<?php }?>
				
			  		<a class="m-btn input-medium" href="<?php echo url('/register/subject')?>"><?php echo Common::translate('register', 'Add Subject')?> <i class="icon-share-alt"></i></a>
				</div>
			</div>
				
		</div>
	</div>

</div>
<!--/span-->
