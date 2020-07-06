$(document).ready(function(){
	alert('ok');
	$(document).on("submit",".customer-form",function(e){
		e.preventDefault();
		var code = $(this).find('input').val();
		$.ajax({
			url: 'umzug/partner-finden/'+code+'/',
			dataType: 'Json'
		}).done(function(response){
			console.log(response);
			
		});
	});
});