<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('register', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/register/tutorSubject')?>"><?php echo Common::translate('register', 'Subjects')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('register', 'Add Subject')?></li>
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
					'htmlOptions'=>array('class'=>"form-horizontal"),
			)); ?>

				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php echo Common::translate('register', 'Subject')?></label>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'ref_subject_id', $subjects)?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('register', 'Level')?></label>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'level', $this->levels, array('class'=>'span2'))?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('register', 'Experience')?>*</label>
					<div class="controls">
						<?php echo $form->textField($model, 'experience', array('class'=>'input-mini', 'placeholder'=>Common::translate('register', 'Experience')))?>
						<?php echo $form->error($model, 'experience')?>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label" for="selectSaluation"><?php echo Common::translate('register', 'Hourly Rate')?>*</label>
					<div class="controls">
						<div class="">
							<?php echo $form->textField($model, 'hourly_rate', array('size'=>16, 'class'=>'input-mini'))?>
							<label style="display: inline;"><?php echo $this->settings['currency']?></label>
							<?php echo $form->error($model, 'hourly_rate')?>
						</div>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="submit" class="m-btn input-medium">
							<?php echo Common::translate('register', 'Submit')?> <i class="m-icon-swapright"></i>
						</button>
					</div>
				</div>
			<?php $this->endWidget()?>

		</div>
	</div>

</div>
