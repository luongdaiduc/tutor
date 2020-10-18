<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li class="active">Users</li>
		</ul>
	</div>

	<h3>Latest</h3>
	
	<?php $this->renderPartial('_view', array('dataProvider'=>$dataProvider))?>

</div>
<!--/span-->
