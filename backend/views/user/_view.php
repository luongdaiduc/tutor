<?php
// 	$this->widget('zii.widgets.grid.CGridView', array(
	$this->widget('XGridView', array(
			'id'=>'user-grid',
			'dataProvider'=>$dataProvider,
			'template'=>'{items}{userButton}{pager}',
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
// 						'value'=>'CHtml::link($data->first_name . " " . $data->last_name, app()->controller->siteUrl . Account::profileLink($data->id))',
						'value'=>'CHtml::link($data->first_name . " " . $data->last_name, app()->controller->siteUrl . url("/tutor/detail", array("id"=>$data->id)))',
				),
				array(
						'header'=>'Email',
						'value'=>'$data->email',
				),
				array(
						'header'=>'Location',
						'value'=>'$data->profiles->suburb',
				),
				array(
						'header'=>'Created',
						'value'=>'date("d M Y", strtotime($data->created))',
				),
				array(
						'header'=>'Paid',
						'value'=>'$data->paidAmount()',		
				),
				array(
						'header'=>'Status',
						'value'=>'Common::statusAccount($data->status)',
				),
				array(
						'header'=>'Last Login',
						'value'=>'!empty($data->last_login) ? date("d M Y", strtotime($data->last_login)) : ""',
				),
				array(
						'header'=>'',
						'type'=>'raw',
						'value'=>'CHtml::link("Login as User", url("/user/loginAsUser", array("id"=>$data->id)), array("target"=>"_blank"))'
				),
			),
	)); 
?>
