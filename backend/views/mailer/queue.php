<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/mailer/queue')?>">Mailer</a> <span class="divider">/</span>
			</li>
			<li class="active">Queues</li>
		</ul>
	</div>
	
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
	
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'queue-grid',
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
								'header'=>'Sender',
								'value'=>'$data->sender_name',
						),
						array(
								'header'=>'Receiver',
								'value'=>'$data->recipient_name',
						),
						array(
								'header'=>'Title',
								'type'=>'raw',
								'value'=>'CHtml::link($data->title, url("/mailer/viewQueue", array("id"=>"$data->id")))',
						),
						array(
								'header'=>'Status',
								'type'=>'raw',
								'value'=>'$data->status == Queue::SUCCESS ? "Success" : "<span class=\'label label-important\'>Pending</span>"',
						),
						array(
								'header'=>'Create',
								'value'=>'date("d M Y H:i:s", strtotime($data->created))',
						),
				),
		));
	?>

</div>
<!--/span-->
