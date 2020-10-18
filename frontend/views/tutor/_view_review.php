<div class="tab-pane fade in active" id="">
	
	<?php if (isset($message)):?>
		<p class="alert-success"><?php echo $message;?></p>
	<?php endif;?>
				
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'summaryText'=>'',
		'itemView'=>'_review_list',
		'pagerCssClass'=>'pagination pagination-centered',
		'pager'=>array(
				'class'=>'CustomPager',
				'header'=>'',
				'prevPageLabel'=>'&#171',
				'nextPageLabel'=>'&#187',
		),
	)); ?>
	
	<?php if(!$is_rated) {?>
		<div>
			<h3><?php echo Common::translate('profile', 'Add a Review')?></h3>
			<?php if(empty($rating_name)) {?>
				<p><?php echo Common::translate('profile', 'Signin to add a review')?>.</p>
			<?php }?>
		</div>
		<?php if(empty($rating_name)) {?>
			<div>
				<ul class="social-login">
					<li><a class="facebook" href="<?php echo app()->params['siteUrl'] . url('/hybridauth/default/login/provider/facebook')?>" target="_parent">Sign in with Facebook</a></li>
					<li><a class="google" href="<?php echo app()->params['siteUrl'] . url('/hybridauth/default/login/?provider=google')?>" target="_parent">Sign in with Google</a></li>
					<li><a class="twitter" href="<?php echo app()->params['siteUrl'] . url('/hybridauth/default/login/?provider=twitter')?>" target="_parent">Sign in with Twitter</a></li>
				</ul>
			</div>
		<?php } else {?>
		
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'rating-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
					),
					'htmlOptions'=>array('class'=>"form-horizontal"),
			)); ?>
				
				<?php // rating
					$this->widget('CStarRating',array(
						'model'=>$model,
						'attribute'=>'rating', // an unique name
						'starCount'=>5,
						'readOnly'=>false,
						'minRating'=>1,
						'maxRating'=>5,
						'allowEmpty'=>false,
						'callback'=>"function(){
			        		
					   }",
				   ));
				?>     
				
				<div style="clear: both;"></div>
				<span><?php echo $form->error($model, 'rating')?></span>
				
				<div style="clear: both;"></div>
					
				<p></p>
				
				<div class="controls" style="margin-left: 0px;">
					<?php echo $form->textArea($model, 'content', array('placeholder'=>Common::translate('profile', 'Content'), 'class'=>'span8', 'rows'=>'3'))?>
					<?php echo $form->error($model, 'content')?>
				</div>
			
				<div class="control-group">
					<div class="controls" style="margin-left: 0px;">
						<button type="submit" class="m-btn input-medium">
							<?php echo Common::translate('profile', 'Submit')?> <i class="m-icon-swapright"></i>
						</button>
					</div>
				</div>
			<?php $this->endWidget();?>
		<?php }?>
	<?php }?>
</div>
<!--/.reviews tab -->
