<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li class="active">Admin</li>
		</ul>
	</div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Username</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($admins as $idx => $admin) {?>
				<tr>
					<td><?php echo $idx + 1;?></td>
					<td><?php echo $admin->first_name?></td>
					<td><?php echo $admin->last_name?></td>
					<td><?php echo $admin->email?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>




</div>
<!--/span-->
