//Job search Page
$(document).ready(function(){
	if ($("body").hasClass("OfferPage")){
		var filter = [];
		$(document).on("click",'[data-filter]',function(){
			filter[] = {filter: $(this).attr('data-filter'), value: $(this).attr('data-filter-value')};
			console.log(filter);
		});

	}
});