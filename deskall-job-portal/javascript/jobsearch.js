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

function ApplyFilter(){
	var filter = [];
	$("[data-filter].uk-active").each(function(){
		filter.push({filter: $(this).attr('data-filter'), value: $(this).attr('data-filter-value')});
	});
	console.log(filter);
}