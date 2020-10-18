<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="/subject">Subjects</a> <span class="divider">/</span>
			</li>
			<li><?php echo $model->isNewRecord ? 'Create' : 'Edit'?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'subject-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
			)); ?>
				
				<div class="form-line">
					<label class="sf-label required" for="inputEmail">Subject*</label>
					<div class="controls">
						<?php echo $form->textField($model, 'name', array('class'=>'sf-input', 'placeholder'=>'Subject'))?>
						<?php echo $form->error($model, 'name'); ?>
					</div>
				</div>
				
				<div class="form-line">
					<label class="sf-label required" for="inputEmail">Parent</label>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'ref_parent_id', $parent_subjects, array('empty'=>''))?>
					</div>
				</div>

				<div class="form-line">
					<button type="submit" class="m-btn input-medium">
						Save <i class="m-icon-swapright"></i>
					</button>
				</div>
			<?php $this->endWidget();?>

		</div>
	</div>

</div>
