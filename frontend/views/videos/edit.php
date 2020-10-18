<?php if($this->settings['video_enable'] == 1) {?>
	<div class="span10">
		<div>
			<ul class="breadcrumb">
				<li><a href="/"><?php echo Common::translate('register', 'Profile')?>Home</a> <span class="divider">/</span>
				</li>
				<li><a href="<?php echo url('/tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
				</li>
				<li><a href="<?php echo url('/videos/index')?>"><?php echo Common::translate('account', 'Videos')?></a> <span class="divider">/</span>
				</li>
				<li><?php echo Common::translate('account', 'Add Video')?></li>
			</ul>
		</div>
	
		<div class="row-fluid">
			<div class="span12">
	
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'add-video-form',
						'enableClientValidation'=>true,
						'clientOptions'=>array(
								'validateOnSubmit'=>true,
						),
						'htmlOptions'=>array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
				)); ?>
	
					<div class="control-group">
	                    <label class="control-label" for="selectSaluation"><?php echo Common::translate('account', 'URL')?>*</label>
	                    <div class="controls">
	                     	<?php echo $form->textField($model, 'video_url', array('class'=>'input-xxlarge', 'placeholder'=>'YouTube URL'))?>
	                     	<?php echo $form->error($model, 'video_url')?>
	                    </div>
	               </div>
	
	               <div class="control-group">
	                    <label class="control-label" for="inputEmail"><?php echo Common::translate('account', 'Title')?>*</label>
	                    <div class="controls">
	                    	<?php echo $form->textField($model, 'title', array('class'=>'input-xxlarge', 'placeholder'=>Common::translate('account', 'Title')))?>
	                    	<?php echo $form->error($model, 'title')?>
	                    </div>
	               </div>
	
	               <div class="control-group">
	                    <label class="control-label" for="inputEmail"><?php echo Common::translate('account', 'Description')?></label>
	                    <div class="controls">
	                    	<?php echo $form->textArea($model, 'description', array('class'=>'input-xxlarge', 'rows'=>'2', 'placeholder'=>Common::translate('account', 'Description')))?>
	                    	<?php echo $form->error($model, 'description')?>
	                    </div>
	               </div>
	
					<div class="control-group">
					 	<div class="controls">
					 		<p><?php echo Common::translate('account', 'Youtube Thumbnail will be used as a representation of this video')?>. </p>
					 	</div>
	               </div>
	               
	               <div class="control-group">
	                    <div class="controls">
	                         <button type="submit" class="m-btn input-medium"><?php echo Common::translate('profile', 'Submit')?> <i class="m-icon-swapright"></i></button>
	              		</div>
	               </div>
				<?php $this->endWidget();?>
	
			</div>
		</div>
	
	</div>
<?php }?>