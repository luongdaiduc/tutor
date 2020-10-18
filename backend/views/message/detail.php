<div class="span10">

	<div>
		<ul class="breadcrumb">
			<li><a href="/">Admin</a> <span class="divider">/</span>
			</li>
			<li><a href="<?php echo url('/message')?>">Messages</a> <span class="divider">/</span>
			</li>
			<li class="active">Read Message</li>
		</ul>
	</div>
	
	<div id="content_show">
	<?php $this->renderPartial('_detail', array('message'=>$message))?>
	</div>
	
	<hr />

	<div class="control-group">
		<div class="controls">
			
			<button type="button" class="m-btn input-medium" id="delete_message" value="<?php echo $message->id?>"><i class="icon-trash"></i>Delete</button>
			
			<span id="reply_message">
            	<a href="<?php echo url('/message/reply', array('id'=>$message->id))?>" class="m-btn input-medium"><i class="icon-share-alt"></i>Reply</a>
            </span>
                      
			<button type="submit" class="m-btn input-medium step_button" id="prev" rel="<?php echo url('/message/detail')?>" value="<?php echo $prev?>" <?php echo empty($prev) ? 'style="display:none"' : "";?> >
				<i class="m-icon-swapleft"></i> Previous
			</button>
			<button type="submit" class="m-btn input-medium step_button" id="next" rel="<?php echo url('/message/detail')?>" value="<?php echo $next?>" <?php echo empty($next) ? 'style="display:none"' : "";?> >
				Next <i class="m-icon-swapright"></i>
			</button>
		</div>
	</div>

</div>
<!--/span-->
