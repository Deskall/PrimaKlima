 $(document).ready(function(){
 	let reference,
 		id,
 		activeCategory,
 		categoryDisplayed;

 	DisplayCategory();

 	UIkit.util.on('#category-filter', 'afterFilter', function(){
 		DisplayCategory();
 	});
 	
 	$(document).on("click", ".reference-box", function(){
 		reference = $(this);
 		id = $(this).attr('data-id');
 		$.ajax({
 			url: '/portfolio/detail/'+id
 		}).done(function(resp){
 			if (resp){
 				UIkit.modal.dialog(resp);
 			}
 		});
 	});

 	function DisplayCategory(){
 		activeCategory = $(".portfolioblock").find('.uk-active');
 		categoryDisplayed = $(".portfolioblock").find('#category-displayed');
 		categoryDisplayed.text(activeCategory.find('a').text());
 	}
 	

 });