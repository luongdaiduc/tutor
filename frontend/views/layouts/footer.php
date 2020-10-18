<footer class="footer">
	<div class="row-fluid">
		<div class="span3">
			<p>
				&copy; <a href="http://www.ossigeno.com" target="_blank">Ossigeno Pty Ltd <?php echo date('Y')?></a>
			</p>
		</div>
		<!--/span-->
		<div class="span9">
			<ul class="nav pull-right">
				<li><a href="<?php echo app()->params['siteUrl'] . url('page/index', array('slug'=>'about'))?>"><?php echo Common::translate('footer', 'About')?></a>
				</li>
				<li><a href="<?php echo app()->params['siteUrl'] . url('/site/sitemap')?>"><?php echo Common::translate('footer', 'Sitemap')?></a>
				</li>
				<li><a href="<?php echo app()->params['siteUrl'] . url('page/index', array('slug'=>'privacy'))?>"><?php echo Common::translate('footer', 'Privacy')?></a>
				</li>
				<li><a href="<?php echo app()->params['siteUrl'] . url('page/index', array('slug'=>'terms-conditions'))?>"><?php echo Common::translate('footer', 'Terms & Conditions')?></a>
				</li>
			</ul>
		</div>
		<!--/span-->
	</div>
	<!--/row-->
</footer>
