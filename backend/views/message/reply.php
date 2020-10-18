<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/message')?>">Messages</a> <span class="divider">/</span>
			</li>
			<li class="active">Reply Message</li>
		</ul>
	</div>
	
	<h2>
		<?php echo $message->title?>
	</h2>
	<h4>
		<?php echo $message->sender_name . '( ' . $message->sender_email . ')'?>
	</h4>
	<h5>
		<?php echo date('d M Y H:i', strtotime($message->created))?>
	</h5>
	
	<hr />
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'reply-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
				'htmlOptions'=>array('class'=>''),
	)); ?>
		<div class="control-group">
			<div class="controls">
				<?php echo $form->textArea($model, 'content', array('class'=>'input-xxlarge', 'rows'=>'5'))?>
				<?php echo $form->error($model, 'content')?>
			</div>
		</div>
        
		<hr />
		
		<?php echo $message->content?>
		<hr />
		
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="m-btn input-medium"><i class="icon-envelope"></i> Send</button>
				<button type="button" class="m-btn input-medium" onclick="window.location.href='<?php echo url('/message/index')?>'"><i class="m-icon-swapright"></i> Cancel</button>
			</div>
		</div>
		
	<?php $this->endWidget();?>
	

</div>
<!--/span-->
