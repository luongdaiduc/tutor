<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/">Home</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/site/login')?>">Login</a> <span class="divider">/</span>
			</li>
			<li class="active">Forgotten Password</li>
		</ul>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php if(!empty($page) && !empty($page->blocks)) {?>
				<?php $this->renderPartial('_block', array('page'=>$page))?>
			<?php }?>
			
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
	
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'forgot-password-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>'form-horizontal'),
			)); ?>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Email</label>
					<div class="controls">
						<?php echo $form->textField($model, 'email', array('placeholder'=>'Email'))?>
						<?php echo $form->error($model, 'email')?>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="submit" class="m-btn input-medium">
							Send Reminder <i class="m-icon-swapright"></i>
						
						</button>
					</div>
				</div>
			<?php $this->endWidget();?>
		</div>
	</div>

</div>
<!--/span-->
