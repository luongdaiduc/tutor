<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Translate</li>
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
		
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
	
	<?php if(!empty($texts)) {?>
		<?php foreach($texts as $text) {?>
			<div class="control-group">
				<label class="control-label" for=""><?php echo $text->message;?></label>
				<div class="controls">
					<input class='input-xxlarge' type="text" value="<?php echo $text->getTranslateMessage();?>" name='Translate[<?php echo $text->id?>]'/>
				</div>
			</div>
		<?php }?>
		<p>Please don't change the text inside "{...}".</p>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="m-btn input-medium">
					Submit <i class="m-icon-swapright"></i>
				</button>
			</div>
		</div>
	<?php }?>
	
	<?php $this->endWidget();?>
	
</div>
<!--/span-->
