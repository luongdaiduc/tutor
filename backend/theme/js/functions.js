function manageMultiRecord(url, action, grid)
{
	var ids = [];
	
	$('.select-on-check').each(function() {
		if($(this).is(':checked'))
		{
			ids.push($(this).val());
		}
	});
	
	if(ids.length > 0)
	{
		if(action == 'delete')
		{
			var r=confirm("Are you sure!");
			
			if(r)
			{
				$.ajax({
					url: url,
					type:'POST',
					data: {'ids': ids.toString(), 'action': action},
					dataType: 'json',
					beforeSend: function() {
						
					},
					success: function(data) {
						if (data.success) {
							$.fn.yiiGridView.update(grid);
						}
						if(!data.success)
						{
							$.fn.yiiGridView.update(grid);
							$('.alert-success').html(data.message);
							$('.alert-success').show();
							
							$('.alert-success').fadeOut(5000);
						}
						//use in edit user
						if(data.redirect)
						{
							window.location.href = data.url;
						}
					}
				});
			}
		}
		else
		{
			$.ajax({
				url: url,
				type:'POST',
				data: {'ids': ids.toString(), 'action': action},
				dataType: 'json',
				beforeSend: function() {
					
				},
				success: function(data) {
					if (data.success) {
						$.fn.yiiGridView.update(grid);
					}
					if(!data.success)
					{
						$.fn.yiiGridView.update(grid);
						$('.alert-success').html(data.message);
						$('.alert-success').show();
						
						$('.alert-success').fadeOut(5000);
					}
					if(data.redirect)
					{
						window.location.href = data.url;
					}
				}
			});
		}
		
	}
	
	return false;
}

function manageFaq(url, action)
{
	var ids = [];
	
	$('.select-on-check').each(function() {
		if($(this).is(':checked'))
		{
			ids.push($(this).val());
		}
	});
	
	if(ids.length > 0)
	{
		if(action == 'delete')
		{
			var r=confirm("Are you sure!");
			
			if(r)
			{
				$.ajax({
					url: url,
					type:'POST',
					data: {'ids': ids.toString(), 'action': action},
					dataType: 'json',
					beforeSend: function() {
						
					},
					success: function(data) {
						if (data.success) {
							window.location.reload();
						}
					}
				});
			}
		}
		else
		{
			$.ajax({
				url: url,
				type:'POST',
				data: {'ids': ids.toString(), 'action': action},
				dataType: 'json',
				beforeSend: function() {
					
				},
				success: function(data) {
					if (data.success) {
						window.location.reload();
					}
				}
			});
		}
		
	}
	
	return false;
}

$(document).ready(function() {
	//hide step in create tutor
//	$('#step2').hide();
	
	$('.alert-success').fadeOut(5000);
	
	//home setting
	$("#kms").tagit({
		singleField: true,
        singleFieldNode: $('#search_km_choices'),
	});	
	
	$("#reviews").tagit({
		singleField: true,
        singleFieldNode: $('#search_review_choices'),
	});	

	$("#feedbacks").tagit({
		singleField: true,
	    singleFieldNode: $('#search_feedback_choices'),
	});	

	//view previous, next record
	$('.step_button').click(function() {
		var id = $(this).val();
		var url = $(this).attr('rel');
		
		$.ajax({
			url:	url,
			type:	'POST',
			data:	{'id': id},
			dataType: 'json',
			beforeSend: function() {
				
			},
			success: function(data) {
				if(data.success)
				{
					$('#content_show').html(data.html);

					if(data.hide_prev)
					{
						$('#prev').hide();
					}
					else if(data.hide_next)
					{
						$('#next').hide();
					}
					else
					{
						$('#prev').show();
						$('#next').show();
					}
					
					$('#prev').val(data.prev_id);
					$('#next').val(data.next_id);
					
					//change reply and delete button in view message detail
					$('#delete_message').val(data.delete_id);
					$('#reply_message').html(data.reply_message);
					
					//hide or show send mail button in view queue detail
					if(data.queue_status == '1')
					{
						$('#send_queue').hide();
					}
					else
					{
						$('#send_queue').show();
					}
					
					//update queue id
					$('#queue_id').val(data.queue_id);
				}
			}
		});
	});
	
	//send queue mail button
	var queue_status = $('#queue_status').val();
	
	if(queue_status == '1')
	{
		$('#send_queue').hide();
	}
	
	//send queue mail when view
	$('#send_queue').click(function() {
		queue_id = $('#queue_id').val();
		
		$.ajax({
			url: '/mailer/sendQueueMail',
			type: 'POST',
			data: {'queue_id': queue_id},
			dataType: 'json',
			beforeSend: function()
			{
				
			},
			success: function()
			{
				window.location.href = '/mailer/queue';
			}
		});
	});
	
	//delete message when view
	$('#delete_message').on('click', function() {
		var id = $(this).val();
		
		$.ajax({
			url: '/message/delete',
			type: 'POST',
			data: {'id': id},
			dataType: 'json',
			beforeSend: function() {
				
			},
			success: function() {
				window.location.href = '/message/index';
			}
		});
	});
	
	//get tutor id in admin send message 
	$('.tutor_check').change(function() {
		var ids = [];
		
		$('.tutor_check').each(function() {
			if($(this).is(':checked'))
			{
				ids.push($(this).val());
			}
		});
		
		$('#tutor_ids').val(ids.toString());
	});
	
	//show tutors in admin send message
	$("#selectUsers").change(function() {
        if($(this).val() == "selected")
        {
        	$("#tutors").fadeIn();
        }
        else
        {
        	$("#tutors").fadeOut();
        }
         
    });
	
	//change faq order
	$('.icon-chevron-up').live('click', function() {
		var id = $(this).attr('id');
		
		id = id.split('-');
		id = id[1];
		
		changeOrder(id, 'up')
	});
	
	//change faq order
	$('.icon-chevron-down').live('click', function() {
		var id = $(this).attr('id');
		
		id = id.split('-');
		id = id[1];
		
		changeOrder(id, 'down')
	});
	
	$('#test_mail').click(function() {
		var name = $('#reply_name').val();
		var email = $('#reply_address').val();
		
		$.ajax({
			url: '/setting/testMail',
			type: 'POST',
			data: {'name': name, 'email': email},
			dataType: 'json',
			beforeSend: function() {
				$("#test_mail").hide();
			},
			success: function(data)
			{
				$("#test_mail").show();
			},
		});
	});
});

function changeOrder(id, type)
{
	$.ajax({
		url: '/faq/changeOrder',
		type: 'POST',
		data: {'id': id, 'type': type},
		dataType: 'json',
		beforeSend: function() {
			
		},
		success: function(data) {
			if(data.success)
			{
				var current = $('#'+data.id);
				var change = $('#'+data.change_id);
				var change_html = change.html();
				
				change.html(current.html());
				change.attr('id', data.id);
				current.html(change_html);
				current.attr('id', data.change_id);
				
			}
		},
	});

}