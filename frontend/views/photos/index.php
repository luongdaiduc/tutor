<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Gallery')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php 
				$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'gallery-grid',
						'dataProvider'=>$dataProvider,
						'template'=>'{items} {pager}',
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
										'header'=>Common::translate('account', 'Image'),
										'type'=>'raw',
										'value'=>'CHtml::link(CHtml::image(app()->baseUrl . "/" . Common::getUserImageFolder($data->ref_account_id) . "/thumb-" . $data->photo, "", array("width"=>"150")), url("/photos/edit", array("id"=>$data->id)))',
								),
								array(
										'header'=>Common::translate('account', 'Description'),
										'value'=>'$data->description',
								),
								array(
										'header'=>Common::translate('account', 'Favourite'),
										'type'=>'raw',
										'value'=>'$data->is_favourite == 1 ? CHtml::tag("div", array("class"=>"active_star"), "") : ""',
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
							<li><a href="#" onclick = "return manageMultiRecord('/photos/manageMultiRecord', 'favourite', 'gallery-grid');" ><?php echo Common::translate('account', 'Make Favourite')?></a>
							</li>
							<li><a href="#" onclick = "return manageMultiRecord('/photos/manageMultiRecord', 'delete', 'gallery-grid');" ><?php echo Common::translate('account', 'Delete')?></a>
							</li>
						</ul>
					<?php }?>
					
					<a class="m-btn input-medium" href="<?php echo url('/photos/edit')?>"><?php echo Common::translate('account', 'Add Image')?>
						<i class="icon-share-alt"></i>
					</a>
				</div>

			</div>


		</div>

	</div>
</div>
