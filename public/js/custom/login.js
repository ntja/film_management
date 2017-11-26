/**
 * Script for log in user in using AJAX
 */

(function($) {
    $(document).ready(function() {

        var form;
        form = $("#login");
        var  user_token = window.localStorage.getItem('user_token');
        
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
                password: {
                    required: true
                }
            }
        });		
		
        function validate() {
            return form.valid();
        } 		
        //When user clcik on login button
        $('#submit_btn').click(function(e) {
        e.preventDefault();
		$('#submit_btn').attr('disabled','disabled');
		//console.log($('#email').val());
        if (validate()) {
            var url, email, password, data;
            url = config.api_url + '/users/authenticate';
            email = $('#email').val();
            password = $('#password').val(); 
            data = {
                "email": email,
                "password": password,
            };
            console.log(data);
            //console.log(JSON.stringify(data))                
            $.ajax({
                url: url,
                type: "POST",
                contentType: "application/json",
                crossDomain: true,
                dataType: "json",
                data: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            // if everything is ok
            .done(function(data, textStatus, jqXHR) {
				alertNotify("Successful authentication", 'success');
                var uri;
                 var return_url = qs()?qs().return_url:null;
				window.localStorage.setItem('user_token', data.token);
				window.localStorage.setItem('user_id', data.id);
				if(return_url){
					uri = return_url;				
                } else{
                    uri = base_url + '/films';
                }                                   
                setTimeout(function(){
                    window.location.assign(uri);
                },1000);  
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alertNotify("An error occured. Please do check your input(s)", 'error');
				$('#submit_btn').removeAttr('disabled');
            });
        }else{
            $('#submit_btn').removeAttr('disabled');
        }
        });
	});
})(jQuery);
