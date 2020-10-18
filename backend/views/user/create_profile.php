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
			'id'=>'create-profile-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
					'validateOnSubmit'=>true,
			),
			'htmlOptions'=>array('class'=>"form-horizontal", 'enctype'=>'multipart/form-data',),
	)); ?>
	
		<?php $this->renderPartial('_profile', array('form'=>$form, 'profile'=>$profile))?>
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
