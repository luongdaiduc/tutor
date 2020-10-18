<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Messages</li>
		</ul>
	</div>
	
	<?php if (isset($alert)):?>
		<p class="alert-success"><?php echo $alert;?></p>
	<?php endif;?>
	
	<?php
		$this->widget('XGridView', array(
				'id'=>'message-grid',
				'dataProvider'=>$dataProvider,
				'template'=>'{items}{selectedAction}{pager}',
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
							'header'=>'Created',
							'value'=>'date("d M Y H:i", strtotime($data->created))',
					),
					array(
							'header'=>'From',
							'value'=>'$data->sender_name',
					),
					array(
							'header'=>'Title',
							'type'=>'raw',
							'value'=>'$data->is_read == Message::UNREAD ?  "<strong>" . CHtml::link($data->title, url("/message/detail", array("id"=>$data->id))) . "</strong>" : CHtml::link($data->title, url("/message/detail", array("id"=>$data->id)))',
					),
				),
		)); 
	?>

</div>
<!--/span-->
