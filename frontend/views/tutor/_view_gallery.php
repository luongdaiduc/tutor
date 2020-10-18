<div class="tab-pane fade in active" id="">
	<div class="row">
		<div class="span16">
			<ul class="thumbnails">
				<?php 
					if(!empty($photos)) 
					{
						foreach ($photos as $photo)
						{
				?>
							<li>
								<a href="<?php echo app()->baseUrl . '/' . Common::getUserImageFolder($photo->ref_account_id)?>/<?php echo $photo->photo;?>" class="thumbnail fancybox" rel="group">
									<img src="<?php echo app()->baseUrl . '/' . Common::getUserImageFolder($photo->ref_account_id)?>/thumb-<?php echo $photo->photo;?>" alt="" style="width: 260px; height: 180px"/>
								</a>
							</li>
				<?php			
						}
					}
					else 
						echo '<li>No result found.</li>'
				?>
			</ul>
		</div>
	</div>
</div>
<!--/.gallery tab -->


<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo app()->baseUrl?>/theme/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo app()->baseUrl?>/theme/plugins/fancybox/source/jquery.fancybox.js?v=2.1.0"></script>
<link rel="stylesheet" type="text/css" href="<?php echo app()->baseUrl?>/theme/plugins/fancybox/source/jquery.fancybox.css?v=2.1.0" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?php echo app()->baseUrl?>/theme/plugins/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.3" />
<script type="text/javascript" src="<?php echo app()->baseUrl?>/theme/plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.3"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?php echo app()->baseUrl?>/theme/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.6" />
<script type="text/javascript" src="<?php echo app()->baseUrl?>/theme/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.6"></script>

<script type="text/javascript">
	$('.fancybox').fancybox();
</script>