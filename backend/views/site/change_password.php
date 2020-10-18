<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/">Home</a> <span class="divider">/</span>
			</li>
			<li class="active">Change Password</li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
	
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'change-password-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>'form-horizontal'),
			)); ?>
				<div class="control-group">
					<label class="control-label" for="inputEmail">New Password</label>
					<div class="controls">
						<?php echo $form->passwordField($model, 'newPassword', array('placeholder'=>'New Password'))?>
						<?php echo $form->error($model, 'newPassword')?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Re-type Password</label>
					<div class="controls">
						<?php echo $form->passwordField($model, 'passwordRepeat', array('placeholder'=>'Re-type Password'))?>
						<?php echo $form->error($model, 'passwordRepeat')?>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="m-btn input-medium">
							Change Password <i class="m-icon-swapright"></i>
						
						</button>
					</div>
				</div>
			<?php $this->endWidget();?>
		</div>
	</div>

</div>
<!--/span-->
