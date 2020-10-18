<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/upgrade')?>"><?php echo Common::translate('account', 'Billing')?></a> <span class="divider">/</span>
			</li>
			<li><?php echo Common::translate('account', 'Upgrade')?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<?php 
				if(!empty($page) && !empty($page->blocks))
				{
					foreach ($page->blocks as $block)
					{
						if($block->status == Block::PUBLISHED)
						{
							$this->beginWidget('zii.widgets.CPortlet', array('htmlOptions'=>array('class'=>'')));
							echo $block->body;
							$this->endWidget();
						}
					}
				}
			?>
			<hr />
			
			<?php if (isset($message)):?>
				<p class="alert-success"><?php echo $message;?></p>
			<?php endif;?>
			
			<ul class="thumbnails">
				<li class="span4">
					<div class="thumbnail">
						
						<div class="caption">
							<h3>Free Basic Package</h3>
							<p>
								<?php 
									if(!empty($basic) && !empty($basic->blocks))
									{
										foreach ($basic->blocks as $block)
										{
											if($block->status == Block::PUBLISHED)
											{
												$this->beginWidget('zii.widgets.CPortlet', array('htmlOptions'=>array('class'=>'')));
												echo $block->body;
												$this->endWidget();
											}
										}
									}
								?>
							</p>
						</div>
					</div>
				</li>
				<li class="span4">
					<div class="thumbnail">
	
						<div class="caption">
							<h3>Silver Package</h3>
							<p>
								<?php 
									if(!empty($enhance) && !empty($enhance->blocks))
									{
										foreach ($enhance->blocks as $block)
										{
											if($enhance->status == Block::PUBLISHED)
											{
												$this->beginWidget('zii.widgets.CPortlet', array('htmlOptions'=>array('class'=>'')));
												echo $block->body;
												$this->endWidget();
											}
										}
									}
								?>
							</p>
							<p>
								<?php echo CHtml::dropDownList('enhance', '', Subscription::model()->getEnhance(), array('class'=>'enhance_choice'))?>
								
							</p>
							<span id="enhance_upgrade">
								<?php echo $enhance_pay_url; ?>
							</span>	
						</div>
					</div>
				</li>
				<li class="span4">
					<div class="thumbnail">
	
						<div class="caption">
							<h3>Gold Package</h3>
							<p>
								<?php 
									if(!empty($premium) && !empty($premium->blocks))
									{
										foreach ($premium->blocks as $block)
										{
											if($premium->status == Block::PUBLISHED)
											{
												$this->beginWidget('zii.widgets.CPortlet', array('htmlOptions'=>array('class'=>'')));
												echo $block->body;
												$this->endWidget();
											}
										}
									}
								?>
							</p>
							<p>
                            	<a href="<?php echo url('/tutor/premium')?>" class="btn btn-primary"><?php echo Common::translate('account', 'Upgrade')?></a>
                            </p>
<!-- 							<p> -->
								<?php //echo CHtml::dropDownList('premium', '', Subscription::model()->getPremium(), array('class'=>'subscription_choice'))?>
<!-- 							</p> -->
<!-- 							<span id="premium_upgrade"> -->
								<?php //echo $premium_pay_url; ?>
<!-- 							</span>	 -->
						</div>
					</div>
				</li>
			</ul>

		</div>
	</div>



</div>
<!--/span-->

