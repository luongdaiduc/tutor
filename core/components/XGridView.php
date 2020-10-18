<?php
Yii::import('zii.widgets.grid.CGridView');
class XGridView extends CGridView
{
	/**
	 * @override
	 * Render user button item in template.
	 */
	public function renderUserButton()
	{
		$delete = "return manageMultiRecord('/user/manageRecord', 'delete', 'user-grid');";
// 		$edit = "return manageMultiRecord('/user/manageRecord', 'login', 'user-grid');";
		$enable = "return manageMultiRecord('/user/manageRecord', 'enable', 'user-grid');";
		$disable = "return manageMultiRecord('/user/manageRecord', 'disable', 'user-grid');";
		
		//hide edit, delete, ban button if data is empty
		if($this->dataProvider->totalItemCount > 0)
		{
			echo '<div class="btn-group">
			<a class="btn btn-primary" href="#"><i class="icon-user"></i>
			User</a> <a class="btn btn-primary dropdown-toggle"
			data-toggle="dropdown" href="#"><span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#" onclick="' . $delete .'"><i class="icon-trash"></i> Delete</a></li>
				<li><a href="#" onclick="' . $enable .'"><i class="icon-play-circle"></i> Enable</a></li>
				<li><a href="#" onclick="' . $disable .'"><i class="icon-ban-circle"></i> Disable</a></li>
				<li class="divider"></li>
				<li><a href="' . url('/user/createAccount') . '"><i class="i"></i>Create</a></li>
			</ul>
			</div>';
		}
		else 
		{
			echo '<div class="btn-group">
			<a class="btn btn-primary" href="#"><i class="icon-user"></i>
			User</a> <a class="btn btn-primary dropdown-toggle"
			data-toggle="dropdown" href="#"><span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="' . url('/user/createAccount') . '"><i class="i"></i>Create</a></li>
			</ul>
			</div>';
		}
// 		<li><a href="#" onclick="' . $edit .'"><i class="icon-pencil"></i> Login as User</a></li>
	}
	
	/**
	 * @override
	 * Render selected action item in template.
	 */
	public function renderSelectedAction()
	{
		$delete = "return manageMultiRecord('/message/manageMultiRecord', 'delete', 'message-grid');";
		$read = "return manageMultiRecord('/message/manageMultiRecord', 'mark_read', 'message-grid');";
		$unread = "return manageMultiRecord('/message/manageMultiRecord', 'mark_unread', 'message-grid');";
	
		if($this->dataProvider->totalItemCount > 0)
		{
			echo '<div class="m-btn-group">
					<a class="m-btn" href="#">With Selected<a class="m-btn dropdown-carrettoggle" data-toggle="dropdown" href="#"><span class="caret"></span>
					</a>
					<ul class="m-dropdown-menu">
						<li><a href="#" onclick="' . $delete .'"><i class=""></i> Delete</a></li>
						<li><a href="#" onclick="' . $read .'"><i class=""></i> Mark as Read</a></li>
						<li><a href="#" onclick="' . $unread .'"><i class=""></i> Mark as Unread</a></li>
					</ul>
				</div>
			
				<div class="m-btn-group">
			        <a href="' . url('/message/send') . '" class="m-btn input-medium">Create <i class="m-icon-swapright"></i>
			        </a>
			    </div>';
		}
		else 
		{
			echo '<div class="m-btn-group">
					<a href="' . url('/message/send') . '" class="m-btn input-medium">Create <i class="m-icon-swapright"></i>
					</a>
				</div>';
		}
	}
	
	/**
	 * @override
	 * Render selected action item in template.
	 */
	public function renderDeleteButton()
	{
		$delete = "return manageMultiRecord('/alert/manageMultiRecord', 'delete', 'alert-grid');";
	
		echo '<div class="m-btn-group">
		<a class="m-btn" href="#">With Selected<a class="m-btn dropdown-carrettoggle" data-toggle="dropdown" href="#"><span class="caret"></span>
		</a>
		<ul class="m-dropdown-menu">
		<li><a href="#" onclick="' . $delete .'"><i class=""></i> Delete</a></li>
		</ul>
		</div>';
	}
}