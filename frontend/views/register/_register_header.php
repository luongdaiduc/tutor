<ul class="steps">
	<li <?php echo $this->action->id == 'account' ? 'class="active"' : ''?> ><?php echo Common::translate('register', 'Step 1')?><span><?php echo Common::translate('register', 'Login Details')?></span></li>
	<li <?php echo $this->action->id == 'profile' ? 'class="active"' : ''?> ><?php echo Common::translate('register', 'Step 2')?><span><?php echo Common::translate('register', 'Contact Information')?></span></li>
	<li <?php echo $this->action->id == 'advertise' ? 'class="active"' : ''?> ><?php echo Common::translate('register', 'Step 3')?><span><?php echo Common::translate('register', 'Background')?></span></li>
	<li <?php echo $this->action->id == 'subject' ? 'class="active"' : ''?> ><?php echo Common::translate('register', 'Step 4')?><span><?php echo Common::translate('register', 'Subject Expertise')?></span></li>
</ul>
