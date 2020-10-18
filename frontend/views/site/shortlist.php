<div class="span10">
	<?php 
		$shortlist_ids = isset(Yii::app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
// 		$checked_row = 'in_array($data->id, array(' . $shortlist_ids . '))';
	?>
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('content', 'Home')?></a> <span class="divider">/</span></li>
			<li><?php echo Common::translate('content', 'Shortlist')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php
				if(isset($dataProvider->totalItemCount) && $dataProvider->totalItemCount != 0) 
				{
					$this->widget('zii.widgets.CListView', array(
					'id'=>'tutor-grid',
					'dataProvider'=>$dataProvider,
					'template'=>'{items} {pager}',
					'itemsTagName'=>'table',
					//'selectableRows'=>2,
					'afterAjaxUpdate'=>"function() { $('#tutor-grid .select-on-check-all').hide(); }",
					'itemsCssClass'=>'table table-striped table-hover table-condensed',
					'pagerCssClass'=>'pagination pagination-centered',
					'pager'=>array(
							'class'=>'CustomPager',
							'header'=>'',
							'prevPageLabel'=>'Prev',
							'nextPageLabel'=>'Next',
					),
					'itemView'=> '/search/_tutor_item',
					'viewData'=> array('shortlist_ids' => $shortlist_ids)
				)); 
				}
				else 
				{
					echo Common::translate('content', 'No result found');
				}
			?>
			
		</div>
	</div>
	
</div>
