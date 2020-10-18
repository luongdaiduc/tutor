<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('register', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo Common::translate('register', 'Register')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php $this->renderPartial('_register_header')?>
			
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'register-profile-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>"form-horizontal", 'enctype'=>'multipart/form-data',),
			)); ?>
			
				<?php $this->renderPartial('_profile', array('form'=>$form, 'profile'=>$profile))?>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="m-btn input-medium" onclick="window.location.href = '<?php echo url('/register/account')?>'">
							<i class="m-icon-swapleft"></i> <?php echo Common::translate('register', 'Previous')?>
						</button>
						<button type="submit" class="m-btn input-medium">
							<?php echo Common::translate('register', 'Next')?> <i class="m-icon-swapright"></i>
						</button>
					</div>
				</div>
				
			<?php $this->endWidget();?>
		</div>
	</div>

</div>
<!--/span-->
