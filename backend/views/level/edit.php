<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/level')?>">Subject Level</a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo $model->isNewRecord ? 'Create' : 'Edit'?></li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'level-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<div class="control-group">
            <label class="control-label" for="selectSaluation">Name*</label>
            <div class="controls">
            	<?php echo $form->textField($model, 'name', array('class'=>'input-xlarge', 'placeholder'=>'Name'))?>
            	<?php echo $form->error($model, 'name')?>
            </div>
        </div>
	
		<div class="control-group">
			<label class="control-label" for="selectSaluation">Status</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'status', array('0'=>'Disable', '1'=>'Active'), array('class'=>'span2'))?>
			</div>
		</div>

		<a href="<?php echo url('/level')?>" class="m-btn input-medium">Cancel <i
			class="m-icon-swapright"></i>
		</a>
	
		<button type="submit" class="m-btn input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
