$(document).ready(function() {
	$('#rating div.rating-cancel').hide();

	$('.alert-success').fadeOut(15000);
	
	//crop image, tutor's gallery
	//$('#crop_image').imgAreaSelect({ aspectRatio: '13:9', handles: true });
	//$('#crop_image').imgAreaSelect({ x1: 0, y1: 0, x2: 65, y2: 45 });
    $('#crop_image').imgAreaSelect({
    	aspectRatio: '13:9', 
    	handles: true,
    	x1: 0, 
    	y1: 0, 
    	x2: 65, 
    	y2: 45,
        onSelectEnd: function (img, selection) {
            $('input[name="x1"]').val(selection.x1);
            $('input[name="y1"]').val(selection.y1);
            $('input[name="x2"]').val(selection.x2);
            $('input[name="y2"]').val(selection.y2);            
        }
    });
	
	//hide check all check box in tutor grid
    $('#tutor-grid .select-on-check-all').hide();
    $('#shortlist-grid .select-on-check-all').hide();
    
	//set gender in advance search form
	$('.gender').click(function() {
		var male_check = $('#male').is(':checked');
		var female_check = $('#female').is(':checked');
		if((male_check && female_check) ||(!male_check && !female_check))
		{
			$('#gender').val('Any');
		}
		else if(male_check)
		{
			$('#gender').val('Male');
		}
		else
		{
			$('#gender').val('Female');
		}
	});

	//load teacher in home page
	$('#load_teacher').click(function(evt) {
		evt.preventDefault();
		
		var subject = $('#teacher_subjects').val();
		
		$.ajax({
			url: '/site/loadTeacher',
			type: 'POST',
			data: {'subject': subject},
			dataType: 'json',
			beforeSend: function() {
				$('#loading').show();
			},
			success: function(data) {
				if(data.success)
				{
					$('#random_teacher').html(data.html);
					$('#subject_name').html(data.subject_name);
				}
				$('#loading').hide();
			}
		});
	});
	
	//show tab in tutor profile detail
    $('#profileTabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
    
    $('#asearch_button').click(function(evt) {
    	var is_map = $('#is_map').val();

    	if(is_map == 1)
    	{
    		evt.preventDefault();
    		ajaxFilter();
    	}
    });
    
    //set paypal link for enhance upgrade
    $('.enhance_choice').change(function() {
//    	var total = 0;
//    	
//    	$('.subscription_choice').each(function() {
//    		if($(this).val() != '')
//    		{
//    			var val = parseInt($(this).val())
//    			total = total + val;
//    		}
//    	});
//    	
//    	$('#total').html(total);
    	
    	var subscription_id = $(this).val();
    	var type = $(this).attr('id');
    	
    	$.ajax({
    		url: '/tutor/changePaypalLink',
    		type: 'POST',
    		data: {'subscription_id': subscription_id, 'type':type},
    		dataType: 'json',
    		beforeSend: function() 
    		{
    			$('#' + type + '_upgrade').hide();
    		},
    		success: function(data)
    		{
    			if(data.success)
    			{
    				$('#' + data.type + '_upgrade').html(data.html);
    				$('#' + data.type + '_upgrade').show();
    			}
    		}
    	});
    });
    
    $('.premium_choice').change(function() {
    	var total = 0;
    	var subscription_subject_ids = [];
    	
    	$('.premium_choice').each(function() {
    		if($(this).val() != '')
    		{
    			var val = $(this).val();
    			
    			val = val.split('-');
    			
    			amount = parseInt(val[1]);
    			total = total + amount;
    			
    			subscription_subject_ids.push(val[0]+"-"+$(this).attr('id'));
    			
    		}
    	});
    	
    	$('#total').html(total);
    	

    	$.ajax({
    		url: '/tutor/changePremiumLink',
    		type: 'POST',
    		data: {'subscription_subject_ids': subscription_subject_ids.toString(), 'total': total,},
    		dataType: 'json',
    		beforeSend: function() 
    		{
    			$('.btn-primary').hide();
    		},
    		success: function(data)
    		{
    			if(data.success)
    			{
    				$('#premium_upgrade').html(data.html);
    				$('.btn-primary').show();
    			}
    		}
    	});
    });
    
    //set value for slider after change subject in search
    $('#subject').change(function() {
    	var subject = $(this).val();
    	
    	$.ajax({
    		url: '/search/valueSlider',
    		type: 'POST',
    		data: {'subject': subject},
    		dataType: 'json',
    		beforeSend: function()
    		{
    			
    		},
    		success: function(data)
    		{
    			if(data.success)
    			{
    				var min_rate = parseInt(data.min_rate);
    				var max_rate = parseInt(data.max_rate);
    				var min_experience = parseInt(data.min_experience);
    				var max_experience = parseInt(data.max_experience);
    				
    				//rate slider
    				$("#rate_slider").slider({
    				    range: true,
    				    min: min_rate,
    				    max: max_rate,
    				    values: [min_rate,max_rate],
    				    slide: function (event, ui) {
    				    	$("#rate_value").html(ui.values[0] + '-' + ui.values[1]);
    				        $("#min_rate").val(ui.values[0]);
    				        $("#max_rate").val(ui.values[1]);
    				    }
    				});

    				$("#min_rate").val(min_rate);
    				$("#max_rate").val(max_rate);
    				$("#rate_value").html(min_rate + '-' + max_rate);
    				
    				//experience slider
    				$("#experience_slider").slider({
    				    range: true,
    				    min: min_experience,
    				    max: max_experience,
    				    values: [min_experience,data.max_experience],
    				    slide: function (event, ui) {
    				        $("#experience_value").html(ui.values[0] + '-' + ui.values[1]);
    				        $("#min_experience").val(ui.values[0]);
    				        $("#max_experience").val(ui.values[1]);
    				    }
    				});

    				$("#min_experience").val(min_experience);
    				$("#max_experience").val(max_experience);
    				$("#experience_value").html(min_experience + '-' + max_experience);
    			}
    		},
    	});
    });
    
    //set tutor shortlist id by cookie
    $('.short-list .select-on-check').live('click', function() {
    	var tutor_shortlist_ids = getCookieValue('tutor_shortlist_ids');

    	if($(this).is(':checked'))
		{
    		if(tutor_shortlist_ids != '')
    		{
    			tutor_shortlist_ids += ',' + $(this).val();
    		}
    		else
    		{
    			tutor_shortlist_ids = $(this).val();
    		}
    		
    		document.cookie="tutor_shortlist_ids=" + tutor_shortlist_ids + ';path=/;';
		}
    	else 
    	{ //uncheck
    		tutor_shortlist_ids = tutor_shortlist_ids.split(",");
    		
    		var index = tutor_shortlist_ids.indexOf($(this).val());
    		
    		tutor_shortlist_ids.splice(index, 1);
    		
    		tutor_shortlist_ids = tutor_shortlist_ids.toString();
    		document.cookie="tutor_shortlist_ids=" + tutor_shortlist_ids.toString() + ';path=/;';
    	}

    });
    
});

//get cookie
function getCookieValue(key)
{
    currentcookie = document.cookie;
    
    if (currentcookie.length > 0)
    {
        firstidx = currentcookie.indexOf(key + "=");
        if (firstidx != -1)
        {
            firstidx = firstidx + key.length + 1;
            lastidx = currentcookie.indexOf(";",firstidx);
            if (lastidx == -1)
            {
                lastidx = currentcookie.length;
            }
            return unescape(currentcookie.substring(firstidx, lastidx));
        }
    }
    return "";
}

//render feature tutor show on the top of search result
//function featureTutor()
//{
//	var ids = [];
//	$('.select-on-check').each(function () {
//		ids.push($(this).val());
//	});
//	
//	var premium_ids = $('#premium_ids').val();
//
//	if(premium_ids != '')
//	{
//		$.ajax({
//			url: '/search/premium',
//			type:'POST',
//			data: {'ids': ids.toString(), 'premium_ids': premium_ids},
//			dataType: 'json',
//			beforeSend: function() {
//				
//			},
//			success: function(data) {
//				if (data.success) {
//					$('#feature_tutor').html(data.html);
//				}
//				
//			},
//		});
//	}
//}


function ajaxFilter()
{
	$.ajax({
		url: '/search/map',
		type:'POST',
		cache: false,
		data: $('#asearch_form').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#loading_image').show();
		},
		success: function(data) {
			if (data.success)
			{
				$('#alert_message').hide();
				
				GMap.summaries = data.summaries;
			    GMap.titles = data.titles;
				GMap.latlngs = data.latlngs;
				
				GMap.initialize();
			}
			else
			{
				$('#alert_message').show();
				
				GMap.latlngs = '';
				GMap.initialize();
			}
			$('#loading_image').hide();
		}
	});
	
}

///****** Google map functions *******/
var GMap = {
	titles: null,
	summaries: null,
	cursor: 0,
	el: 'map_canvas',
	latlngs: null,
	
	//function for filter service page
	initialize: function()
	{
		obj = this;

		el = this.el;
		latlngs = this.latlngs;
		titles = this.titles;
	    		
	    map = new google.maps.Map(document.getElementById(el), {mapTypeId: google.maps.MapTypeId.ROADMAP , zoom: 11,});
	    var bounds = new google.maps.LatLngBounds();

	    length = latlngs.length;
	    
	    for(var i =0; i < length; i++)
	    {
			obj.cursor = i;
	    	var latlng = latlngs[i];
	    		    
	    	var myLatlng = new google.maps.LatLng(latlng[0], latlng[1]);
			   
		    map.setCenter(myLatlng);
		    var marker = new google.maps.Marker({
                map: map,
                position: myLatlng,
	        });	
	
		    bounds.extend(myLatlng);		   
		    obj.attachMessage(marker, obj.cursor);	
	    }
	    
	    if(length > 1)
	    {
	    	map.fitBounds(bounds);	   
	    }
	    
	},

	/**
	 * Add map marker window
	 */
	attachMessage: function(marker, idx)
	{
		titles = this.titles;
		summaries = this.summaries;
		var infowindow = new google.maps.InfoWindow({
   	 		content: '<div style="float:left;"><h5 style="padding-bottom:5px"><a href="' + titles[idx]['url'] + '">' + titles[idx]['name'] + '</a><br/><p>' + summaries[idx] + '</p></div>'
   	 	});
			
   	 	google.maps.event.addListener(marker, 'click', function() {
   	 		infowindow.open(marker.get('map'), marker);
   	 	});
   	 
	}
};

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