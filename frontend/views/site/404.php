<!--/span-->
<?php $this->beginContent('//layouts/main'); ?>

	<div class="span12">
	
		<div id="error_container">
			<div id="error_type">404 Page not found</div>
			<div id="error_body">
				<p class="error_message">We cannot find a resource matching your
					request</p>
				<p>We're sorry. The page you requested could not be found. This page
					may have been moved, deleted, or perhaps you entered it incorrectly.
					Please re-enter the URL and try again. Alternatively, you can:</p>
				<p>
					Return to the <a href="<?php echo app()->params['siteUrl']?>"><?php echo $this->settings['site_title']?>
					</a>
				</p>
			</div>
		</div>
	
	</div>

<?php $this->endContent(); ?>