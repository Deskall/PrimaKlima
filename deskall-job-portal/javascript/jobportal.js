$(document).ready(function(){
	$(document).on("click","[data-edit-offer]",function(){
		var id = $(this).attr('data-edit-offer');
		$.ajax({
			url: window.location.pathname+'JobofferForm',
			dataType: 'html',
			data: {offerId: id}
		}).done(function(response){
			$("#edit-form-container").empty().append(response);
		});
	});
});