<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/block')?>">Blocks</a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo $model->isNewRecord ? 'Create' : 'Edit'?></li>
		</ul>
	</div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'page-form',
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
            <label class="control-label" for="selectSaluation">Target*</label>
            <div class="controls">
            	<?php echo $form->dropDownList($model, 'target', $pages, array('class'=>'span2', 'multiple'=>"multiple"))?>
            	<?php echo $form->error($model, 'target')?>
            </div>
        </div>
        
		<div class="control-group">
			<label class="control-label" for="inputEmail">Body*</label>
			<div class="controls">
				<?php 
					$this->widget('application.components.editMe.widgets.ExtEditMe', array(
							'model'=>$model,
							'attribute'=>'body',
							//'ckeConfig'=> array('skin'=>'office2003'),
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
				<?php echo $form->error($model, 'body')?>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="selectSaluation">Status</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'status', array('0'=>'Draft', '1'=>'Published'), array('class'=>'span2'))?>
			</div>
		</div>

		<a href="/block" class="m-btn input-medium">Cancel <i
			class="m-icon-swapright"></i>
		</a>
	
		<button type="submit" class="m-btn input-medium">
			Save <i class="m-icon-swapright"></i>
		</button>
		
	<?php $this->endWidget();?>

</div>
<!--/span-->
