<div class="span10">
	<div>
		<ul class="breadcrumb">
			<li><a href="/"><?php echo Common::translate('account', 'Home')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/tutor/index')?>"><?php echo Common::translate('account', 'My Account')?></a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/reviews/index')?>"><?php echo Common::translate('account', 'Reviews')?></a> <span class="divider">/</span>
			</li>
			<li>Review by <?php echo $review->post_by?></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">

			<blockquote>
				<?php echo $review->showStar($review->rating)?>
				<div style="clear: both;"></div>
				<p><?php echo $review->content?></p>
				<small><?php echo $review->post_by . ' ' . date('d F Y', strtotime($review->created))?></small>
			</blockquote>

		</div>

	</div>
</div>
