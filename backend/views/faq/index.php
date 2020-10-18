<?php $item_count = 0;?>
<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span></li>
			<li class="active">FAQs</li>
		</ul>
	</div>
	<?php if (isset($message)):?>
	<p class="alert-success">
		<?php echo $message;?>
	</p>
	<?php endif;?>

	<table class="table table-striped table-hover table-condensed table-fluid" name="results">
		<thead>
			<tr>
				<th></th>
				<th>Title</th>
				<th>Created</th>
				<th>Modified</th>
				<th>Published</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($generals)) {?>
				<tr class='group'>
					<td colspan="6"><strong>General</strong>
					</td>
				</tr>
				<?php foreach ($generals as $general) {?>
					<?php $this->renderPartial('_faq_item', array('data'=>$general))?>
				<?php }?>
			<?php $item_count++; }?>
			
			<?php if(!empty($students)) {?>
				<tr class='group'>
					<td colspan="6"><strong>Student</strong>
					</td>
				</tr>
				<?php foreach ($students as $student) {?>
					<?php $this->renderPartial('_faq_item', array('data'=>$student))?>
				<?php }?>
			<?php $item_count++; }?>
			
			<?php if(!empty($tutors)) {?>
				<tr class='group'>
					<td colspan="6"><strong>Tutor</strong>
					</td>
				</tr>
				<?php foreach ($tutors as $tutor) {?>
					<?php $this->renderPartial('_faq_item', array('data'=>$tutor))?>
				<?php }?>
			<?php $item_count++; }?>
			
			<?php echo $item_count == 0 ? '<tr><td colspan="6"><strong>No result found.</strong></td></tr>' : '';?>
		</tbody>
	</table>

	<?php if($item_count > 0) {?>
		<div class="m-btn-group">
			<a class="m-btn blue">With Selected</a> <a class="m-btn blue dropdown-carrettoggle" data-toggle="dropdown" href="#"> <span class="caret"></span> </a>
			<ul class="m-dropdown-menu">
				<li><a href="#" onclick="return manageFaq('<?php echo url('/faq/manageMultiRecord')?>', 'delete');" ><i class="icon-trash"></i> Delete</a>
				</li>
				<li><a href="#" onclick="return manageFaq('<?php echo url('/faq/manageMultiRecord')?>', 'publish');" ><i class="icon-play-circle"></i> Publish</a>
				</li>
				<li><a href="#" onclick="return manageFaq('<?php echo url('/faq/manageMultiRecord')?>', 'draft');" ><i class="icon-ban-circle"></i> Draft</a>
				</li>
			</ul>
		</div>
	<?php }?>
	
	<div class="m-btn-group">
		<a href="<?php echo url('/faq/edit')?>" class="m-btn blue input-medium">Create
			<i class="m-icon-swapright m-icon-white"></i>
		</a>
	</div>

</div>
<!--/span-->
