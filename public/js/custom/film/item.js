/**
 * Script to get all films
 */
(function($) {
    $(document).ready(function() {
		
		var film_slug = $("#film").data('film'), film_id=null;
		var user_token = window.localStorage.getItem('user_token'),user_id = window.localStorage.getItem('user_id');
		url = config.api_url + '/films/' + film_slug;
		get_film(url);
		
		$('body').delegate('.comment', 'click',function(){			
			if(!user_token){
				window.location.assign(base_url + '/login?return_url='+base_url + '/films/'+film_slug);
			}
			var comment_content = $("textarea.content").val();
			console.log(comment_content);
			if(comment_content){
				add_comment(user_id, comment_content);				
			}
		});
		
		// Custom Functions
		function get_film(url) {
			$.ajax({
				url: url,
				method: "GET",
				crossDomain: true,
				dataType: "json",				
			})
			.done(function(data, textStatus, jqXHR) {
				var result = data.data, genres = result.genres, comments = result.comments, html = '';
				film_id = result.id;
				html += '<a href="#">';
				html += '<img class="avatar border-gray" src="'+base_url+'/public/uploads/'+result.photo+'" alt="...">';
				html += '<h4 class="title">'+result.name+'<br>';
				html += '<small>Country: '+result.country+'</small><br>';
				html += '<small>Ticket Price: '+result.ticket_price+'</small><br>';				
				html += '<small>rating: '+result.rating+'</small><br>';
				html += '<small>Released date: '+result.release_date+'</small><br>';
				if(genres){
					html += '<small>Genres:</small>';
					for(i=0; i<genres.length; i++){
						html += '<h6><i>'+genres[i].name+'</i></h6>';
					}
				}
				html += '<br></h4>';
				html += '</a>';
				html += '</div>';
				html += '<p class="description text-center"> '+result.description+' <br>';
				html += '</p>';				
				$("#film").append(html);
				if(comments){
					html = '';
					html += '<h4>Comments:</h4>';
					for(i=0; i<comments.length; i++){
						html += '<row><h5><i>'+comments[i].full_name+'</i> : <small>'+comments[i].content+'</small></h5></row>';
					}					
					$("#comment").append(html);
				}
				$("#comment").append('<div class="row"><div class="col-md-8"><div class="form-group"><textarea rows="5" class="content form-control" ></textarea><button type="button" class="comment btn btn-info pull-left">Add Comment</button></div></div></div>');				
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
			});        
		}  
		
		function add_comment(user_id, comment_content) {
			data = {
				"user": user_id,
				"content": comment_content
			};                                
			$.ajax({
				url: config.api_url + '/films/' + film_id+'/comments',
				type: "POST",
				contentType: "application/json",
				crossDomain: true,
				dataType: "json",
				headers: {
					"x-access-token": user_token
				},
				data: JSON.stringify(data)
			})
			// if everything is ok
			.done(function(data, textStatus, jqXHR) {					
				alertNotify("Well done ! Your account has been successfully created", 'success');
				window.location.reload();
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alertNotify("An error occured. Please do check your input(s)", 'error');
			});
		}
    });    
})(jQuery);