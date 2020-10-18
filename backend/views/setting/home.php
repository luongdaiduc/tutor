<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Settings</li>
		</ul>
	</div>

	<?php $this->renderPartial('/setting/_menu')?>

	<form class="form-horizontal" method="POST">
		<div class="tab-content">
			<div class="tab-pane fade in active" id="profile">
				
				<?php if (isset($message)):?>
					<p class="alert-success"><?php echo $message;?></p>
				<?php endif;?>
	
				<div class="control-group">
					<label class="control-label" for="inputEmail">Search Km Choices</label>
					<input type="hidden" value="<?php echo $kms;?>" id="search_km_choices" name="search_km_choices" />
					<div class="controls">
						<ul id="kms" class="ml0 w270">
							<!-- Existing list items will be pre-added to the tags -->
						</ul>
					</div>
					
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Search Feedback Choices</label>
					<div class="controls">
						<input type="hidden" value="<?php echo $feedbacks?>" id="search_feedback_choices" name="search_feedback_choices"/>
						<ul id="feedbacks" class="ml0 w270">
							<!-- Existing list items will be pre-added to the tags -->
						</ul>
					</div>
				</div>
		
				<div class="control-group">
					<label class="control-label" for="inputEmail">City</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="City" value="<?php echo $city->value?>" name="city">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Site Title</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Site Title" value="<?php echo $site_title->value?>" name="site_title">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Default language</label>
					<div class="controls">
						<?php echo CHtml::dropDownList('language', $language->value, Common::allLanguages(), array('class'=>'span2'))?>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Default Currency</label>
					<div class="controls">
						<?php echo CHtml::dropDownList('currency', $currency->value, Common::getCurrencies(), array('class'=>'span2'))?>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Default Currency Symbol</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Default Currency Symbol" value="<?php echo $default_currency_symbol->value?>" name="default_currency_symbol">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Short Date Format</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Short Date Format" value="<?php echo $short_date_format->value?>" name="short_date_format">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Long Date Format</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Long Date Format" value="<?php echo $long_date_format->value?>" name="long_date_format">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Meta Keywords</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Meta Keywords" value="<?php echo $meta_keywords->value?>" name="meta_keywords">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Meta Description</label>
					<div class="controls">
						<textarea rows="3" class="input-xlarge" placeholder="Meta Description" name="meta_description"><?php echo $meta_description->value?></textarea>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Google Analytics Account</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Google Analytics Account" value="<?php echo $google_analytics_account->value?>" name="google_analytics_account">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Google API Key</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Google API Key" value="<?php echo $google_api_key->value?>" name="google_api_key">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Google Api Secret</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Google Api Secret" value="<?php echo $google_api_secret->value?>" name="google_api_secret">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Facebook API Key</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Facebook API Key" value="<?php echo $facebook_api_key->value?>" name="facebook_api_key">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Facebook Api Secret</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Facebook Api Secret" value="<?php echo $facebook_api_secret->value?>" name="facebook_api_secret">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Twitter API Key</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Twitter API Key" value="<?php echo $twitter_api_key->value?>" name="twitter_api_key">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Twitter Api Secret</label>
					<div class="controls">
						<input class="input-xlarge" type="text" placeholder="Twitter Api Secret" value="<?php echo $twitter_api_secret->value?>" name="twitter_api_secret">
					</div>
				</div>
			
				<button type="submit" class="m-btn input-medium">
					Save <i class="m-icon-swapright"></i>
				</button>
			</div>
		</div>
	</form>
</div>