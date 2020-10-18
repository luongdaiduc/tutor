<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/mailer/queue')?>">Mailer</a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo $model->isNewRecord ? 'Create' : 'Edit'?></li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'template-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Name*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'name', array('class'=>'input-xlarge', 'placeholder'=>'Title'))?>
				<?php echo $form->error($model, 'name')?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="inputEmail">Subject*</label>
			<div class="controls">
				<?php echo $form->textField($model, 'subject', array('class'=>'input-xlarge', 'placeholder'=>'Subject'))?>
				<?php echo $form->error($model, 'subject')?>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="inputEmail">Content*</label>
			<div class="controls">
				<?php //echo $form->textArea($model, 'content', array('class'=>'span8', 'placeholder'=>'Content - markup allowed', 'rows'=>8))?>
				<?php 
					$this->widget('application.components.editMe.widgets.ExtEditMe', array(
							'model'=>$model,
							'attribute'=>'content',
							'toolbar'=>array(
						 	    array(
						 	        'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 
						 	    ),
						 	    array(
						 	        'NumberedList', 'BulletedList',
						 	    ),
						 	    array(
						 	        'Styles', 'Format', 'Font', 'FontSize',
						 	    ),
						 	    array(
						 	        'TextColor', 'BGColor',
						 	    ),
								array('Source')
						  ),
					));
				?>
				<?php echo $form->error($model, 'content')?>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="inputEmail">Description*</label>
			<div class="controls">
				<?php echo $form->textArea($model, 'description', array('class'=>'span8', 'placeholder'=>'Description', 'rows'=>3))?>				
				<?php echo $form->error($model, 'description')?>
			</div>
		</div>
		
		<a href="/mailer/template" class="m-btn input-medium">Cancel <i
			class="m-icon-swapright"></i>
		</a>
	
		<button type="submit" class="m-btn input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
