/**
 * Script for Create Film
 */

(function($) {    
    $(document).ready(function() {
		
		// get the list of available film genres
		get_genre();
		
		var form = $("#create");
		form.validate({
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
                error.css({"color":"#F34235"});
            },
            onfocusout: function(element) {				
                $(element).valid();
            },
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true
                },
                country: {
                    required: true
                },
                rating: {
                    required: true
                },
                genre: {
                    required: true
                },
                price: {
                    required: true
                },
                release_date: {
                    required: true
                }
            }
        });

        function validate() {
            result = form.valid();            
            return  result;
        }		
		
        //When user clcik on create film button
        $('#submit_btn').click(function(e) {
            e.preventDefault();
			console.log($('#photo').attr('data-file_name'));
            if(!$('#photo').data('photo')){
				alertNotify('You must upload a photo', 'error');
				return false;
			}
            if (validate()) {
                var url, name,description, data, price, release_date, country, rating, genres;
				
                url = config.api_url + '/films';
				
				name = $('#name').val();
                description = $('textarea#description').val();
                price = $('#price').val();
				release_date = $('#release_date').val();
				country = $('#country').val();
				genres = $('#genres').val();
				rating = $('#rating').val();                
                data = {
                    "name": name,
                    "country": country,
                    "genres": genres,
					"ticket_price" : price,
					"release_date": release_date,
					"rating": rating,
					"description": description,
					"photo": $('#photo').data('photo'),
                };                  
                console.log(JSON.stringify(data))                
                $.ajax({
                    url: url,
                    method: "post",
                    contentType: "application/json",
                    crossDomain: true,
                    dataType: "json",
                    data: JSON.stringify(data)
                })
                // if everything is ok
                .done(function(data, textStatus, jqXHR) {
					$('#create').slideUp('slow');
                    alertNotify("Well done ! Your film has been successfully created", 'success');
					var uri;
					uri = base_url + '/films';
					setTimeout(function(){
						window.location.assign(uri);
					},2000); 
                })                
				.fail(function(jqXHR, textStatus, errorThrown) {
					alertNotify('An Error occured please try again later', 'error');
				});
            }
        });		
		
		
		function get_genre(){
			$.ajax({
				url: config.api_url + '/genres',
				type: "GET",
				contentType: "application/json",				
				dataType: "json",				
			})
			// if everything is ok
			.done(function(data, textStatus, jqXHR) {					
				//console.log(data);				
				var html = '', result = data.data;
				for(i=0; i<result.length; i++){
					html += '<option value="'+result[i].id+'">'+result[i].name+'</option>';
				}
				$("#genres").empty().append(html);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alertNotify("An error occured. We cannot load film Genres", 'error');
			});
		}
	});
})(jQuery);
