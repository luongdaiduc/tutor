<?php if($this->settings['video_enable'] == 1) {?>
	<div class="tab-pane fade in active" id="">
		<?php 
			$this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'video-grid',
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
									'header'=>Common::translate('profile', 'Video'),
									'type'=>'raw',
									'value'=>'CHtml::link(CHtml::image($data->getVideoThumbnail(), "", array("width"=>"150px")), url("/tutor/watchVideo", array("id"=>$data->id)))',
							),
							array(
									'header'=>Common::translate('profile', 'Description'),
									'value'=>'$data->description',
							),
					),
			));
		
		?>
	
	</div>
	<!--/.reviews tab -->
<?php }?>