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
	var filters = [];
	$(".sidebar .filters").empty().attr('hidden','hidden');
	$(".offers-container").attr('data-uk-spinner',true);
	$("[data-filter].uk-active").each(function(){
		filters.push({filter: $(this).attr('data-filter'), value: $(this).attr('data-filter-value')});
		$(".sidebar .filters").append('<button class="uk-button button-SecondaryBackground">'+$(this).attr('data-filter-value')+'</button>');
	});
	if (filters.length > 0){
		$(".sidebar .filters").attr('hidden',false);
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
	
}