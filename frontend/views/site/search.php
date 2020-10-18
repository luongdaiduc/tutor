<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/">Home</a> <span class="divider">/</span></li>
			<li>Search Results</li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php 
				if(isset($dataProvider->totalItemCount) && $dataProvider->totalItemCount != 0) 
				{
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'tutor-grid',
						'dataProvider'=>$dataProvider,
						'template'=>'{items} {pager}',
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
									'header'=>'Tutor',
									'type'=>'raw',
									'value'=>'CHtml::link(CHtml::image(app()->baseUrl . "/" . $data->avatar, "", array("width"=>"150")), "#")',
							),
							array(
									'header'=>'',
									'type'=>'raw',
									'value'=>'CHtml::tag("h5", array(), CHtml::link($data->name, "#")) . $data->getTutorDetail($data->ref_account_id)',
							),
							array(
									'header'=>'Rate',
									'value'=>'$data->default_hourly_rate',
							),
								
							array(
									'header'=>'Reviews',
									'type'=>'raw',
									'value'=>'CHtml::image(app()->baseUrl . "/theme/img/4stars.jpg", "", array())',
							),
								
						),
					)); 
				}
				else 
				{
					echo 'No result found.';
				}
			?>
			
		</div>
	</div>

</div>
</div>



</div>
<!--/span-->
