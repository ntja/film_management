/**
 * Script for registering user in using AJAX
 */

(function($) {
    $(document).ready(function() {		
        var form;
        form = $("#register");        
        var user_token = window.localStorage.getItem('user_token');
        
        // if token exists
        if (user_token) {			
			window.location.assign(base_url + '/films');
		}
		
        form.validate({
            errorElement: 'label',
            //errorClass: 'error',
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
                error.css({'font-size': '0.8em','color' :'#FF4A70' });     							
            },
            onfocusout: function(element) {
                $(element).valid();
            },
            rules: {
                email: {
                    required: true,
                    email: true
                },
				full_name: {
                    required: true
                },		
                password: {
                    required: true,
					minlength: 8
                }
            }
        });

        function validate() {
            return form.valid();
        } 
		
		//When user clcik on register button
		$('#submit_btn').click(function(e) {
            e.preventDefault();
            //  disable the submit button
            $('#submit_btn').attr('disabled','disabled');
            console.log($('#email').val());
            if (validate()) {
                var url, email, password, data;
                url = config.api_url + '/users';
                email = $('#email').val();
                password = $('#password').val();
				full_name = $('#full_name').val();
				
                data = {
                    "email": email,
                    "password": password,
                    "full_name" : full_name
                };                                
                $.ajax({
                    url: url,
                    type: "POST",
                    contentType: "application/json",
                    crossDomain: true,
                    dataType: "json",
                    data: JSON.stringify(data)
                })
                // if everything is ok
                .done(function(data, textStatus, jqXHR) {					
                    $('#register').slideUp('slow');
                    alertNotify("Well done ! Your account has been successfully created", 'success');
					var uri;
					uri = base_url + '/films';
					setTimeout(function(){
						window.location.assign(uri);
					},2000);                          
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    alertNotify("An error occured. Please do check your input(s)", 'error');
					$('#submit_btn').removeAttr('disabled');         
                })
                .always(function() {
                    $('#submit_btn').removeAttr('disabled');
                });
            }else{
				$('#submit_btn').removeAttr('disabled');
            }
        });
	});
})(jQuery);
