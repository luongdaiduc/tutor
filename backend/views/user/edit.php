<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/user')?>">User</a> <span class="divider">/</span>
			</li>
			<li class="active">Edit</li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'user-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<div class="control-group">
			<label class="control-label" for="">First Name*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'first_name', array('class'=>'input-xlarge', 'placeholder'=>'First Name'))?>
				<?php echo $form->error($model, 'first_name')?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="">Last Name*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'last_name', array('class'=>'input-xlarge', 'placeholder'=>'Last Name'))?>
				<?php echo $form->error($model, 'last_name')?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="">Email*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'email', array('class'=>'input-xlarge', 'placeholder'=>'Email'))?>
				<?php echo $form->error($model, 'email')?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="selectSaluation">Status</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'status', array('1'=>'Active', '0'=>'Ban'), array('class'=>'span2'))?>
			</div>
		</div>

		<a href="<?php echo url('/user')?>" class="m-btn input-medium">Cancel <i class="m-icon-swapright"></i>
		</a>
	
		<button type="submit" class="m-btn input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
