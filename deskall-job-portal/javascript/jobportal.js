$(document).ready(function(){
	$(document).on("click","[data-edit-offer]",function(){
		var id = $(this).attr('data-edit-offer');
		// $.ajax({
		// 	url: window.location.pathname+'EditJobOffer',
		// 	dataType: 'html',
		// 	data: {OfferId: id}
		// }).done(function(response){
		// 	$('.toggle-new-offer').attr('hidden','hidden');
		// 	$("#edit-form-container").empty().append(response).attr('hidden',false);
		// });
		$("#offer-form-container").load(window.location.pathname+'EditJobOffer #offer-form-container',function(){
			UIkit.toggle('.toggle-new-offer').toggle();
		});
	});
});