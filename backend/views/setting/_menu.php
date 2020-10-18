<ul class="nav nav-tabs nav-tabs-equal" id="profileTabs">
	<li <?php echo $this->action->id == 'home' ? 'class="active"' : '';?>><a href="<?php echo url('/setting/home')?>">Home</a></li>
	<li <?php echo $this->action->id == 'invoice' ? 'class="active"' : '';?>><a href="<?php echo url('/setting/invoice')?>">Invoice</a></li>
	<li <?php echo $this->action->id == 'mail' ? 'class="active"' : '';?>><a href="<?php echo url('/setting/mail')?>">Mail</a></li>
	<li <?php echo $this->action->id == 'count' ? 'class="active"' : '';?>><a href="<?php echo url('/setting/count')?>">Counts</a></li>
	<li <?php echo $this->action->id == 'video' ? 'class="active"' : '';?>><a href="<?php echo url('/setting/video')?>">Video</a></li>
</ul>
