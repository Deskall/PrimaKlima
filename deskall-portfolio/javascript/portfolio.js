 $(document).ready(function(){
 	let reference;
 	let id;
 	$(document).on("click", ".reference-box", function(){
 		reference = $(this);
 		id = $(this).attr('data-id');
 		$.ajax({
 			url: 'portfolio/fetchReference',
 			dataType: 'html',
 			data: {ReferenceID: id}
 		}).done(function(resp){
 			if (resp){
 				UIkit.modal.dialog(resp);
 			}
 		});
 	});
 });