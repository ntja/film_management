/**
 * Script for edit user profile in using AJAX
 */

(function($) {
    var base_url;      
    base_url = $('body').attr('data-base-url');
    
    $(document).ready(function() {
		
		// call autocomplete function for test names dropdown
		autocomplete();
		var form = $("#create-test");
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
                }
            },
            highlight: function(element, errorClass, validClass) {                
                $(element).addClass(errorClass).removeClass(validClass);                
            }
        });

        function validate() {
            result = form.valid();            
            return  result;
        }		
		
        //When user clcik on create test button
        $('#submit_btn').click(function(e) {
            e.preventDefault();            
            //console.log($('#email').val());
            if (validate()) {
                var url, name,description, data, patient, token;
				
                url = base_url + '/add-test';
				
                description = $('#description').val();
                patient = $('#patient').val();
				token = $('[name="_token"]').val();
                
                data = {
                    "name": name,
                    "patient": patient,
                    "description": description,
					"_token" : token,
                };                
				if (!$('#name').attr('data-id')) {
                    data.name = 0;
                    data.name0 = $('#name').val();
                }
                else{
                    data.name = $('#name').attr('data-id');
                }                 
                console.log(JSON.stringify(data))                
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
					form[0].reset();
					notify(data, 'success');
                })                
				.fail(function(jqXHR, textStatus, errorThrown) {
					notify('An Error occured please try again later', 'danger');
				});
            }
        });		
		
		function autocomplete(){			
			$("#name").autocomplete({
				minLength :1,
				source : function(request, response){
					url = base_url + '/test-names?query='+request.term;                      
					$.ajax({
						url: url,
						type: "GET",
						contentType: "application/json",						
						dataType: "json",						
					})
					// if everything is ok
					.done(function(data, textStatus, jqXHR) {						
						response($.map(data.items, function(object) {
                            return {label: object.name, value: object.id};
                        }));						
					})
					.fail(function(jqXHR, textStatus, errorThrown) {
					});
					//console.log(request);
				},
				focus: function(event, ui){
					//console.log(ui.item);
					return false;
				},
				select: function(event, ui) {					
					$(event.target).val(ui.item.label);
					if (!ui.item || ui.item == null)
						$(event.target).removeAttr('data-id');
					else
						$(event.target).attr('data-id', ui.item.value);
					return false;
				},
				change: function(event, ui) {
					console.log(ui);
					if (!ui.item || ui.item == null){
						$(event.target).removeAttr('data-id');
					}						
					else{
						$(event.target).attr('data-id', ui.item.value);
					}						
				}
			})
			.data("ui-autocomplete")._renderItem = function(ul, item){
				return $("<li>")
				.data("ui-autocomplete-item", item)
				.append("<a> "+ item.label + "</a>")
				.appendTo(ul);
			} ;			
		}
		
		function notify(message, type){
			$.notify(
			{
				message: message
			},
			{
				type:  type
			});
		}
	});
})(jQuery);
