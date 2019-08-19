jQuery(document).ready(function($)
	{
		
		$("#job_bm_location").attr('autocomplete','off');		
		$("#job_bm_location").wrap("<div id='location-list-wrapper'></div>");
		
		$("#location-list-wrapper").append("<div id='location-list'></div>");		

		$(document).on('keyup', '#job_bm_location', function()
			{
				
				var name = $(this).val();
				
				if(name=='' || name == null){
						$("#location-list").html('<div value="" class="item">Start Typing...<div>');
					}
				else{
					
					$.ajax(
						{
					type: 'POST',
					context: this,
					url:job_bm_locations_ajax.job_bm_locations_ajaxurl,
					data: {"action": "job_bm_locations_ajax_job_location_list", "name":name,},
					success: function(data)
							{	
								$("#location-list").html(data);	
							}
						});
					
					}
				
			})



		$(document).on('click', '#location-list .item', function(){
			
				var name = $(this).attr('location-data');
			
				$("#job_bm_location").val(name);
			
			})









	});