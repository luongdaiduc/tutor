<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Reviews')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
		
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
			
			<?php 
				$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'reviews-grid',
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
										'header'=>Common::translate('account', 'Author'),
										'value'=>'$data->post_by',
								),
								array(
										'header'=>Common::translate('account', 'Review'),
										'type'=>'raw',
										'value'=>'CHtml::link($data->content, url("/reviews/view", array("id"=>$data->id)))',
								),
								array(
										'header'=>Common::translate('account', 'Rating'),
										'type'=>'raw',
										'value'=>'$data->showStar($data->rating)',
										'htmlOptions'=>array('style'=>'width:110px'),
								),
								array(
										'header'=>Common::translate('account', 'created'),
										'value'=>'date("d M Y", strtotime($data->created))',
								),
								array(
										'header'=>'',
										'type'=>'raw',
										'value'=>'$data->status == Review::REQUEST_REMOVAL ? CHtml::tag("span", array("class"=>"label label-warning"), "REQUEST REMOVAL") : ""',
								),
						),
				));
			
			?>
			
			<?php if($dataProvider->totalItemCount > 0) {?>
				<div>
					<div class="m-btn-group">
						<a class="m-btn"><?php echo Common::translate('account', 'With Selected')?></a> <a
							class="m-btn btn-rnd-right dropdown-carrettoggle"
							data-toggle="dropdown" href="#"> <span class="caret"></span>
						</a>
						<ul class="m-dropdown-menu">
							<li><a href="#" onclick="return manageMultiRecord('/reviews/manageMultiRecord', 'request', 'reviews-grid');"><?php echo Common::translate('account', 'Request Removal')?></a>
							</li>
							<?php if($is_admin == true) {?>
								<li><a href="#" onclick="return manageMultiRecord('/reviews/manageMultiRecord', 'delete', 'reviews-grid');"><?php echo Common::translate('account', 'Delete')?></a>
								</li>
							<?php }?>
						</ul>
	
					</div>
	
				</div>
			<?php }?>
		</div>

	</div>
</div>
