<?php $empty = true;?>
<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('register', 'Home')?></a> <span class="divider">/</span></li>
			<li><?php echo Common::translate('search', 'Search Results')?></li>
		</ul>
	</div>
	
	<!--======= Feature section ======-->
	<?php 
		if (!empty($feature_account) && $page == 1) 
		{
			$empty = false;
	?>
			<div id="feature_tutor">
				<hr/>
				<?php $this->renderPartial('/site/_feature', array('feature'=>$feature_account, 'subject'=>$subject))?>
				<hr/>
			</div>
	<?php 
		}
	?>
	
	<!--======= Silver section ======-->
	<?php 
		if(!empty($paid_accounts) && $page == 1) 
		{
			$empty = false;
			foreach ($paid_accounts as $paid_account)
			{
				$this->renderPartial('_silver', array('model'=>$paid_account, 'subject'=>$subject));
			}
		}
	?>
	
	<!--======= Normal section ======-->
	<?php 
		if(!empty($models))
		{
			$empty = false;
	?>
			<table class="table table-striped table-hover table-condensed" name="results">
				<thead>
					<th></th>
					<th><?php echo Common::translate('search', 'Name')?></th>
					<th><?php echo Common::translate('search', 'Location')?></th>
					<th><?php echo Common::translate('search', 'From')?></th>
					<th><?php echo Common::translate('search', 'Subjects')?></th>
				</thead>
				<tbody>
				<?php 
					foreach ($models as $model)
					{
						$this->renderPartial('_normal', array('model'=>$model, 'subject'=>$subject));
					}
				?>
				</tbody>
			</table>
	<?php }?>
	
	<?php //$this->renderPartial('_result', array('dataProvider'=>$dataProvider, 'subject'=>$subject, 'feature_account'=>$feature_account))?>
	<div class="pagination pagination-centered">
		<?php $this->widget('SearchPager', array(
				'itemCount' => $total,	
				'pageSize' => $page_size,
				'htmlOptions' => array('class'=>''),
				'header'=>'',
				'prevPageLabel'=>'Prev',
				'nextPageLabel'=>'Next',
			));?>
	</div>
	
	<?php if($empty) echo Common::translate('search', 'No result found');?>
	
	<input type="hidden" id="premium_ids" value="<?php echo $premium_ids?>" />
</div>

