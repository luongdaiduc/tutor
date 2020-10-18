<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/photos/index')?>"><?php echo Common::translate('account', 'Gallery')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Add Image')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'add-photo-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
			)); ?>

				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php echo Common::translate('account', 'Description')?></label>
					<div class="controls">
						<?php echo $form->textArea($model, 'description', array('rows'=>2, 'class'=>'input-xxlarge'))?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('account', 'Favourite')?></label>
					<div class="controls">
						<?php echo $form->checkbox($model, 'is_favourite')?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('account', 'Image')?></label>
					<div class="controls">
						<?php echo $form->fileField($model,'streamPhoto'); ?>	
						<?php echo $form->error($model, 'streamPhoto')?>
						<p class="hint">File types: gif, png, jpeg, jpg. Maximum is 2MB</p>
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
