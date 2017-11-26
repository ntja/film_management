//notification function
function alertNotify(message, type){
	var html = '';		
	if(type=='success'){
		html+= '<div class="alert alert-success" role="alert"><span class="fa fa-check"></span>';	
	}else if(type=='error'){
		html+= '<div class="alert alert-danger" role="alert"><span class="fa fa-times"></span>';	
	}else if(type=='info'){
		html+= '<div class="alert alert-info" role="alert"><span class="fa fa-info"></span>';	
	}else if(type=='warning'){
		html+= '<div class="alert alert-warning" role="alert">';	
	}
	//html+= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
	html+= '<strong> '+ message+'</strong></div>';
	$('.response-message div').addClass(type);
	$('.response-message').empty().html(html);
}
function qs(){
	var url = location.search;
	var qs = url.substring(url.indexOf('?') + 1).split('&');
	if(qs.length == 1 && qs[0]==""){
		return {};
	}else{
		for(var i = 0, result = {}; i < qs.length; i++){
			qs[i] = qs[i].split('=');
			result[qs[i][0]] = decodeURIComponent(qs[i][1]);
		}
		return result;
	}
}