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
		$("#Form_JobOfferForm").load(window.location.pathname+'EditJobOffer #Form_JobOfferForm',function(){
			UIkit.toggle('.toggle-new-offer').toggle();
		});
	});
});