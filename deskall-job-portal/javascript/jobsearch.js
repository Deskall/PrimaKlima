//Job search Page
$(document).ready(function(){
	if ($("body").hasClass("OfferPage")){
		
		$(document).on("click",'[data-filter]',function(){
			$(this).parents('.parameter').find('[data-filter]').removeClass('uk-active');
			$(this).addClass('uk-active');
			ApplyFilter();
		});
		$(document).on("click",'.filters button',function(){
			var filter = $("[data-filter='"+$(this).attr('data-filter-title')+"'][data-filter-value='"+$(this).text()+"']");
			filter.removeClass('uk-active');
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
	var filters = [];
	
	$(".offers-container .spinner").show();
	$("[data-filter].uk-active").each(function(){
		filters.push({filter: $(this).attr('data-filter'), value: $(this).attr('data-filter-value')});
		$(".sidebar .filters").append('<button class="uk-button uk-margin-small" data-filter-title="'+$(this).attr('data-filter')+'">'+$(this).attr('data-filter-value')+'<span class="uk-margin-small-left" data-uk-close></span></button>');
	});
	
	
	$.ajax({
		url: window.location.pathname,
		data: {filters: filters},
		dataType:'html'
	}).done(function(response){
		$(".offers-container").replaceWith(response);
	}).fail(function(response){
		console.log(response);
	});
	
}