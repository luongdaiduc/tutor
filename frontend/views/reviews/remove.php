 <div class="span10">
    <div>
        <ul class="breadcrumb">
           <li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span></li>
           <li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span></li>
           <li><a href="<?php echo url('/reviews/index')?>"><?php echo Common::translate('account', 'Reviews')?></a> <span class="divider">/</span></li>
           <li><?php echo Common::translate('account', 'Request Removal')?></li>
       </ul>
    </div>

	<div class="row-fluid">
	    <div class="span12">
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'summaryText'=>'',
				'itemView'=>'_remove_list',
				'pagerCssClass'=>'pagination pagination-centered',
				'pager'=>array(
						'class'=>'CustomPager',
						'header'=>'',
						'prevPageLabel'=>'&#171',
						'nextPageLabel'=>'&#187',
				),
			)); ?>
			
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'advertise-detail-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>"form-horizontal"),
		)); ?>
			
			<div class="control-group">
				<label class="control-label" for="inputPassword"><?php echo Common::translate('account', 'Reason')?>*</label>
				<div class="controls">
					<?php echo $form->textArea($model, 'message', array('placeholder'=>Common::translate('account', 'Request for requesting removal'), 'rows'=>'3', 'class'=>'input-xlarge'));?>
					<?php echo $form->error($model, 'message'); ?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="m-btn input-medium">
						<?php echo Common::translate('profile', 'Submit')?> <i class="m-icon-swapright"></i>
					</button>
				</div>
			</div>
		<?php $this->endWidget();?>
		</div>
	</div>
</div>