/**
 * Manage News in Backend
 * Author: @Deskall
 */
(function($) {
	 $.entwine(function($) {
		$("#Status.optionset").entwine({
			onmatch: function(){
				var value = $('input[name=Status]:checked').val();
				if (value == "Archived"){
					$(".handlepublish").hide();
				}
			},
			onchange: function(){
				var value = $('input[name=Status]:checked').val(); 
				if (value == "ToBePublished" || value == "Published" ){
					$(".handlepublish").show();
				}
				else {
					$(".handlepublish").hide();
				}
			}
		});


		$("#Form_ItemEditForm_Template").entwine({
			onchange: function(){
			$.ajax({
				type: "POST",
				url: '/admin/notifications/get/template/' + $(this).val(),
				success: function(response){
					data = JSON.parse(response);
					$('#Form_ItemEditForm_Title').val(data['title']);
					$('#Form_ItemEditForm_Lead').val(data['content']);
				}
			});
			return false;
			}
		});


	});
})(jQuery);
