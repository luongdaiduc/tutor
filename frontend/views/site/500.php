<!--/span-->
<?php $this->beginContent('//layouts/main'); ?>

	<div class="span12">
	
		<div id="error_container">
			<div id="error_type">500 Server error</div>
			<div id="error_body">
				<p class="error_message">We cannot process your request</p>
				<p>We're sorry. An error occurred whilst attempting to process your request. We have been notified of this. Please try again. Alternatively, you can:</p>
				<p>
					Return to the <a href="<?php echo app()->params['siteUrl']?>"><?php echo $this->settings['site_title']?></a>
				</p>
			</div>
		</div>
	
	</div>

<?php $this->endContent(); ?>