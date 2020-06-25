$(document).ready(function(){
	$(document).on("click","[data-contact-modal]",function(){
		var card = $(this).parents('.uk-card');
		$("#contact-modal").find('[data-contact]').attr('data-contact',$(this).attr('data-contact-modal'));
		UIkit.modal($("#contact-modal")).show();
	});
	$(document).on("click","[data-contact]",function(){
		var card = $(this).parents('.uk-card');
		var id = $(this).attr('data-contact');
		$.ajax({
			url: cleanUrl(window.location.pathname)+'/showMatch',
			method: 'POST',
			dataType: 'html',
			data: {resultId: id}
		}).done(function(response){
			card.replaceWith(response);
		});
	});
});

function cleanUrl(url){
    if (url.substring(url.length-1) == "/"){
        url = url.substring(0, url.length-1);
    }
    return url;
}