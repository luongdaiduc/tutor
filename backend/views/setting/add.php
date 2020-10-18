<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Add New Site</li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'add-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<?php if (isset($message)):?>
			<p class="alert-success">
				<?php echo $message;?>
			</p>
		<?php endif;?>
		
		<div class="control-group">
            <label class="control-label" for="selectSaluation">Domain*</label>
            <div class="controls">
            	<?php echo $form->textField($model, 'domain', array('class'=>'input-xlarge', 'placeholder'=>'Domain'))?>
            	<?php echo $form->error($model, 'domain')?>
            	<p>Site's domain without www</p>
            </div>
        </div>
        
		<button type="submit" class="m-btn blue input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
