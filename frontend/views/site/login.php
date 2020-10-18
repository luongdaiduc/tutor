<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/">Home</a> <span class="divider">/</span></li>
			<li class="active">Login</li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>'form-horizontal'),
			)); ?>
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
			
			<div class="control-group">
				<label class="control-label" for="inputEmail">Email</label>
				<div class="controls">
					<?php echo $form->textField($model, 'username', array('placeholder'=>'Email'));?>
					<?php echo $form->error($model, 'username')?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password</label>
				<div class="controls">
					<?php echo $form->passwordField($model, 'password', array('placeholder'=>'Password'));?>
					<?php echo $form->error($model, 'password')?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<label class="checkbox"> <?php echo $form->checkBox($model,'rememberMe'); ?> Remember me
					</label>
					
					<button type="submit" class="m-btn input-medium">
						Sign in <i class="m-icon-swapright"></i>
					
					</button>
					<p></p>
                    <a href="<?php echo url('/site/forgotPassword')?>" style="display: block;">Forgotten Password</a>
	              
				</div>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>

</div>
<!--/span-->


