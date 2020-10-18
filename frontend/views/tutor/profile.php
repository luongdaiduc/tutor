<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Contact Details')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'contact-detail-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>"form-horizontal", 'enctype'=>'multipart/form-data',),
			)); ?>
				<?php if (isset($message)):?>
					<p class="alert-success"><?php echo $message;?></p>
				<?php endif;?>
				
				<?php $this->renderPartial('/register/_profile', array('form'=>$form, 'profile'=>$model))?>
				
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