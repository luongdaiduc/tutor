<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Alerts</li>
		</ul>
	</div>

	<?php
		$this->widget('XGridView', array(
				'id'=>'alert-grid',
				'dataProvider'=>$dataProvider,
				'template'=>$dataProvider->totalItemCount > 0 ? '{items}{deleteButton}{pager}' : '{items}{pager}',
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
							'header'=>'Level',
							'value'=>'$data->level',
					),
					array(
							'header'=>'Title',
							'type'=>'raw',
							'value'=>'CHtml::link((strlen($data->title) >= 100 ? substr($data->title, 0, 100) . "..." : $data->title), url("/alert/detail", array("id"=>$data->id)))',
					),
					array(
							'header'=>'Source',
							'value'=>'$data->source',
					),
					array(
							'header'=>'Created',
							'value'=>'date("d M Y H:i", strtotime($data->created))',
					),
					
					
				),
		)); 
	?>

</div>
<!--/span-->
