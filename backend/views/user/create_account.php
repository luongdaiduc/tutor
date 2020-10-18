<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/user')?>">User</a> <span class="divider">/</span>
			</li>
			<li class="active">Create</li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'create-user-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
					'validateOnSubmit'=>true,
			),
			'htmlOptions'=>array('class'=>"form-horizontal",),
	)); ?>
		
		<?php $this->renderPartial('_account', array('form'=>$form, 'model'=>$model))?>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="m-btn input-medium">
					Next <i class="m-icon-swapright"></i>
				</button>
			</div>
		</div>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
