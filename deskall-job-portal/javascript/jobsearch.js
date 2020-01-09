//Job search Page
$(document).ready(function(){
	if ($("body").hasClass("OfferPage")){
		ApplyFilter();
		$(document).on("click",'[data-filter]',function(){
			$(this).parents('.parameter').find('[data-filter]').removeClass('uk-active');
			$(this).addClass('uk-active');
			ApplyFilter();
		});
	}
});

function cleanUrl(url){
    if (url.substring(url.length-1) == "/"){
        url = url.substring(0, url.length-1);
    }
    return url;
}

function ApplyFilter(){
	var filter = [];
	$("[data-filter].uk-active").each(function(){
		filter.push({filter: $(this).attr('data-filter'), value: $(this).attr('data-filter-value')});
	});
	$.ajax({
		url: cleanUrl(window.location.pathname)+'/stellenangebote-filtern/',
		data: {filters: filters},
		dataType:'html'
	}).done(function(response){
		$(".element.offer-page").replaceWith(response);
	}).fail(function(response){
		console.log(response);
	});
}