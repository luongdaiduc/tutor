<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/faq')?>">FAQs</a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo $model->isNewRecord ? 'Create' : 'Edit'?></li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'faq-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<div class="control-group">
            <label class="control-label" for="selectSaluation">Title*</label>
            <div class="controls">
            	<?php echo $form->textField($model, 'title', array('class'=>'input-xlarge', 'placeholder'=>'Title'))?>
            	<?php echo $form->error($model, 'title')?>
            </div>
        </div>
		
		<div class="control-group">
            <label class="control-label" for="selectSaluation">Category*</label>
            <div class="controls">
            	<?php echo $form->dropDownList($model, 'category', Common::getFaqCategories(), array('class'=>'span2'))?>
            	<?php echo $form->error($model, 'category')?>
            </div>
        </div>
        
		<div class="control-group">
			<label class="control-label" for="inputEmail">Body*</label>
			<div class="controls">
				<?php //echo $form->textArea($model, 'content', array('class'=>'span8', 'rows'=>'8'))?>
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
			<label class="control-label" for="selectSaluation">Status</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'status', array('0'=>'Draft', '1'=>'Published'), array('class'=>'span2'))?>
			</div>
		</div>

		<a href="<?php echo url('/faq')?>" class="m-btn blue input-medium">Cancel <i
			class="m-icon-swapright"></i>
		</a>
	
		<button type="submit" class="m-btn blue input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
