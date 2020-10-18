<div class="row-fluid">
	<?php 
		$shortlist_ids = isset(Yii::app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
		//$checked_row = 'in_array($data->id, array(' . $shortlist_ids . '))';
	?>
	<div class="span12">
		<?php 
		if (!empty($feature_account)) {
		?>
			<div id="feature_tutor">
				<hr/>
				<?php $this->renderPartial('/site/_feature', array('feature'=>$feature_account))?>
				<hr/>
			</div>
			
		<?php 
		}
		?>
		
		<?php
			if(isset($dataProvider->totalItemCount) && $dataProvider->totalItemCount != 0) 
			{
				$this->widget('zii.widgets.CListView', array(
					'id'=>'tutor-grid',
					'dataProvider'=>$dataProvider,
					'template'=>'{items} {pager}',
					'itemsTagName'=>'table',
					//'selectableRows'=>2,
					'afterAjaxUpdate'=>"js:function(id, data) 
											{	
												var ids = [];
												$('.select-on-check').each(function () {
													ids.push($(this).val());
												});
												
												var premium_ids = $('#premium_ids').val();
						
												if(premium_ids != '')
												{
													$.ajax({
														url: '/search/premium',
														type:'POST',
														data: {'ids': ids.toString(), 'premium_ids': premium_ids},
														dataType: 'json',
														beforeSend: function() {
															
														},
														success: function(data) {
															if (data.success) {
																$('#feature_tutor').html('<hr/>' + data.html + '<hr/>');
															}
															
														}
													});	
												}
											}",
					'itemsCssClass'=>'table table-striped table-hover table-condensed',
					'pagerCssClass'=>'pagination pagination-centered',
					'pager'=>array(
							'class'=>'CustomPager',
							'header'=>'',
							'prevPageLabel'=>'Prev',
							'nextPageLabel'=>'Next',
					),
					'itemView'=> '_tutor_item',
					'viewData'=> array('shortlist_ids' => $shortlist_ids, 'subject'=> $subject, 'feature_account'=>$feature_account)
				)); 
			}
			elseif ((!isset($dataProvider->totalItemCount) || $dataProvider->totalItemCount == 0) && empty($feature_account)) 
			{
				echo Common::translate('search', 'No result found');
			}
		?>
		
	</div>
</div>
