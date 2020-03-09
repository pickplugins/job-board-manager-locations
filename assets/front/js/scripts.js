jQuery(document).ready(function($)
	{
		
		$(".job-submit #job_bm_location").attr('autocomplete','off');		
		$(".job-submit #job_bm_location").wrap("<div id='location-list-wrapper'></div>");
		
		$(".job-submit #location-list-wrapper").append("<div id='location-list'></div>");		



		$(document).on('keyup', '.job-submit #job_bm_location', function(){
			
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





		$(document).on('click', '.job-submit #location-list .item', function(){
			
				var name = $(this).attr('location-data');
			
				$("#job_bm_location").val(name);
				$(this).parent().fadeOut();
			})
			
			
		$('.job_bm_expand_loc ul').each(function(){
			$this = $(this);
			$this.find("li").has("ul").addClass("hasSubmenu");
		});

		$('.job_bm_expand_loc li:last-child').each(function()
		{
			$this = $(this);
			if ( $this.children('.job_bm_expand_loc ul').length === 0 )
			{} 
			else 
			{
				$this.closest('.job_bm_expand_loc ul').children("li").last().children("a").addClass("addBorderBefore");
				$this.closest('.job_bm_expand_loc ul').css("margin-top","10px");
				$this.closest('.job_bm_expand_loc ul').find("li").children("ul").css("margin-top","10px");
				$this.closest('.job_bm_expand_loc ul').find("li").children("ul").css("display","none");
			};
		});
		
		$('.job_bm_expand_loc ul li.hasSubmenu').each(function(){
			$this = $(this);
			$this.prepend("<a href='#'><i class='fa fa-plus-circle'></i><i style='display:none;color: #E13229 !important;' class='fa fa-minus-circle'></i></a>");
			$this.children("a").not(":last").removeClass().addClass("toogle");
		});
		
		$('.job_bm_expand_loc ul li.hasSubmenu a.toogle').click(function(){
			$this = $(this);
			$this.closest("li").children("ul").toggle("slow");
			$this.children("i").toggle();
			return false;
		});
		
		
	});
