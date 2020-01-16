$(document).ready(function(){
	$(document).on("click","[data-edit-offer]",function(){
		var id = $(this).attr('data-edit-offer');
		$.ajax({
			url: window.location.pathname+'EditJobOffer',
			dataType: 'html',
			data: {OfferId: id}
		}).done(function(response){
			$("#Form_JobOfferForm").load(window.location.pathname+'EditJobOffer #Form_JobOfferForm',function(){
				Uikit.toggle($(".toggle-new-offer")).toggle();
			});
		});
	});

	$(document).on("change","input[name='UseData']",function(){
		if ($(this).is(':checked')){
			$("#cv-container").attr('hidden','hidden');
		}
		else{
			$("#cv-container").attr('hidden',false);
		}
	});
});