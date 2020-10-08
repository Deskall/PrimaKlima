 $(document).ready(function(){
 	let reference;
 	let id;
 	$(document).on("click", ".reference-box", function(){
 		reference = $(this);
 		id = $(this).attr('data-id');
 		$.ajax({
 			url: '/portfolio/fetchReference/'+id
 		}).done(function(resp){
 			if (resp){
 				UIkit.modal.dialog(resp);
 			}
 		});
 	});
 });