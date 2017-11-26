/**
 * Script to get course details using AJAX
 */

(function($) {
    $(document).ready(function() {

        //var base_url = $('body').attr('data-base-url');       
        
		var limit = 1,  uri = config.api_url + "/films?limit="+limit;		
		
		//click on next page link
		$('body').delegate('#next', 'click',function(){			
			var page_url = $(this).data('next');
			get_films(page_url);
		});
		
		//click on previous page link
		$('body').delegate('#previous', 'click',function(){			
			var page_url = $(this).data('previous');
			get_films(page_url);
		});
		
		//Get films list		
		var uri = config.api_url + "/films?limit="+limit;
		get_films(uri);		
		
		//get all films
		function get_films(uri){		
			var result = null;
			$.ajax({
				url: uri,
				method: "GET"				
			})
			.done(function (data, textStatus, jqXHR) {
				//console.log(base_url+'/public/uploads/'+data.data[0].photo);
				var result = data.data, html = '';
				if(result){
					for(i=0; i<result.length; i++){
						html += '<tr>';
						html += '<td>'+result[i].id+'</td>';
						html += '<td><a href="'+base_url+'/films/'+result[i].slug_name+'">'+result[i].name+'</a></td>';
						html += '<td>'+result[i].description+'</td>';
						html += '<td>'+result[i].country+'</td>';
						html += '<td>'+result[i].ticket_price+'</td>';
						html += '<td>'+result[i].release_date+'</td>';
						html += '<td>'+result[i].rating+'</td>';
						html += '<td><img src="'+base_url+'/public/uploads/'+result[i].photo+'" width="50" height="50"></td>';
						html += '</tr>';                                        	
					}
				}
					$('.pagination').empty();
					if(data.next_page_url){
						$('.pagination').append('<li><a href="javascript:void(0)" data-page="'+data.current_page+'" data-next="'+data.next_page_url+'" id="next"> Next &raquo;</a></li>');
					}
					if(data.prev_page_url){			
						$('.pagination').prepend('<li><a href="javascript:void(0)"  data-page="'+data.current_page+'" data-previous="'+data.prev_page_url+'" id="previous"> &laquo; Previous</a></li>');
					}	
				$('#film_list').html(html);				
			})
			.fail(function (jqXHR, textStatus, errorThrown) {
				console.log('request failed !');
			});
		}				
	});
})(jQuery);
