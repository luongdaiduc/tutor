<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="m-btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span>
			</a> 
			<a class="brand" href="/"><?php echo $this->settings['site_title']?></a>
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<?php if(!Yii::app()->user->isGuest) : ?>	
						<li><a href="<?php echo url('/alert')?>" class="navbar-link">Alerts</a>
						</li>
						
	                    <li><a href="<?php echo url('/message')?>">Messages <?php echo Message::countAllUnreadMessage() == 0 ? '' : '(' . Message::countAllUnreadMessage() . ')'?></a></li>
		              	
						<li><a href="<?php echo url('/site/logout')?>" class="navbar-link">Logout</a>
						</li>
					<?php else :?>
						<li><a href="<?php echo url('/site/login')?>" class="navbar-link">Login</a>
						</li>
					<?php endif;?>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
