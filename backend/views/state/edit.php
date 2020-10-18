<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/state')?>">States</a> <span class="divider">/</span>
			</li>
			<li class="active">Edit</li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'state-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<div class="control-group">
			<label class="control-label" for="">State*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'state', array('class'=>'input-xlarge', 'placeholder'=>'Title'))?>
				<?php echo $form->error($model, 'state')?>
			</div>
		</div>
		
		<div class="control-group">
			 <label class="checkbox">
			<?php echo $form->checkbox($model, 'is_default')?> Default
			</label>
		</div>
		
		<a href="<?php echo url('/state')?>" class="m-btn input-medium">Cancel <i class="m-icon-swapright"></i>
		</a>
	
		<button type="submit" class="m-btn input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
