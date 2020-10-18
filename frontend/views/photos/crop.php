<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span></li>
			<li><a href="<?php echo url('/tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span></li>
			<li><a href="<?php echo url('/photos/index')?>"><?php echo Common::translate('account', 'Gallery')?></a> <span class="divider">/</span></li>
			<li>Crop Image</li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			
			<div class="span12" style="overflow: auto;">
				<img id="crop_image" src="<?php echo app()->baseUrl . "/" . Common::getUserImageFolder($model->ref_account_id) . '/' . $model->photo?>" class="crop">
			</div>
			
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'crop-photo-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>'form-horizontal'),
			)); ?>
			
			<input type="hidden" name="x1" value="0" /> 
			<input type="hidden" name="y1" value="0" /> 
			<input type="hidden" name="x2" value="65" />
			<input type="hidden" name="y2" value="45" />
			
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

