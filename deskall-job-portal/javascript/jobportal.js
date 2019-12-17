$(document).ready(function(){
	$(document).on("click","[data-edit-offer]",function(){
		var id = $(this).attr('data-edit-offer');
		$.ajax({
			url: window.location.pathname+'EditJobOffer',
			dataType: 'html',
			data: {offerId: id}
		}).done(function(response){
			$('.toggle-new-offer').attr('hidden','hidden');
			$("#edit-form-container").empty().append(response).attr('hidden',false);
		});
	});
});