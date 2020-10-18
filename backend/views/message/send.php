<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/message')?>">Messages</a> <span class="divider">/</span>
			</li>
			<li class="active">Write Message</li>
		</ul>
	</div>
	
	<?php if (isset($alert)):?>
		<p class="alert-success"><?php echo $alert;?></p>
	<?php endif;?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'reply-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
					'validateOnSubmit'=>true,
			),
			'htmlOptions'=>array('class'=>''),
			)); ?>
	<div class="control-group">
		<label class="control-label" for="inputEmail">From</label>
		<div class="controls">
			<?php echo CHtml::dropDownList('from_choices', '', $from_choices, array('class'=>'input-xlarge'))?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="inputEmail">To</label>
		<div class="controls">
			<select class="input-xlarge" id="selectUsers" name="selectUsers">
				<option value="all">All Tutors</option>
				<option value="active">Active Tutors</option>
				<option value="selected">Selected Tutors</option>
			</select>
		</div>
	</div>

	<p>
	
	
	<div id="tutors" class="collapse in" style="display: none;">

		<div style="overflow: scroll; height: 100px; width: 400px">

			<table class="table table-condensed table-nonfluid">
				<thead>
					<tr>
						<th></th>
						<th>Name</th>
						<th>e-mail</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tutors as $tutor) {?>
					<tr>
						<td><input type="checkbox" class="tutor_check"
							value="<?php echo $tutor->id?>" />
						</td>
						<td><?php echo CHtml::link($tutor->first_name . " " . $tutor->last_name, app()->controller->siteUrl . url("/tutor/detail", array("id"=>$tutor->id)), array('target'=>'_blank'))?>
						</td>
						<td><?php echo $tutor->email?>
						</td>
					</tr>
					<?php }?>

				</tbody>
			</table>

		</div>

	</div>

	</p>

	<hr />

	<div class="control-group">
		<label class="control-label" for="inputEmail">Subject</label>
		<div class="controls">
			<?php echo $form->textField($model, 'subject', array('class'=>'input-xxlarge', 'placeholder'=>'Subject'))?>
			<?php echo $form->error($model, 'subject')?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="inputEmail">Message</label>
		<div class="controls">
			<?php echo $form->textArea($model, 'content', array('class'=>'input-xxlarge', 'placeholder'=>'Message...', 'rows'=>'5'))?>
			<?php echo $form->error($model, 'content')?>
		</div>
	</div>

	<input type="hidden" value="" id="tutor_ids" name="tutor_ids">

	<hr />

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="m-btn input-medium">
				<i class="icon-envelope"></i> Send
			</button>
			<button type="button" class="m-btn input-medium" onclick='window.location.href="<?php echo url('/message/index')?>"'>
				<i class="m-icon-swapright"></i> Cancel
			</button>
		</div>
	</div>
	<?php $this->endWidget()?>

</div>
<!--/span-->
