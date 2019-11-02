$(document).ready(function(){
	if ($(".sidebar-menu").length > 0){
		var sidebarWidth = Math.ceil($(".sidebar-menu").width()) / 4;
		$(".sidebar-menu").css("transform-origin", 'calc(50% + '+sidebarWidth+'px + 4px) 0');
		$(".sidebar-menu").show();
	}

	//responsive height match
	if ($("[data-dk-height-match]").length > 0){
		$("[data-dk-height-match]").each(function(){
			UIkit.heightMatch($(this), {target: $(this).attr('data-dk-height-match')});
		});
	}

	//PLZ Modal
	if ($("#toggle-modal-postal-code").attr('data-active') == "false" && $("#toggle-modal-postal-code").attr('data-trigger') == "true"){
		UIkit.modal($("#modal-postal-code")).show();
	}
	UIkit.util.on("#modal-postal-code","shown",function(){
		$('input[name="plz-choice"]').focus();
	});

	//productblock
	$(document).on('click','.productblock .uk-card',function(){
		window.location.href = $(this).find('.btn-order').attr('href');
	});
});



//Product Choice Scripts
$(document).ready(function(){
	//we fetch the packages
	var packages = [];
	var url = window.location.pathname;
	$.ajax({
		url: '/shop-functions/fetchPackages',
		dataType: 'Json'
	}).done(function(response){
		packages = response;
	});


	//Handle the product slider
	$(document).on("click",".category .uk-slider-items li",function(){
		var slider = $(this).parents('.uk-slider');
		var index = parseInt($(this).attr('data-index')) - 1;
		UIkit.slider(slider).show(index);
		slider.parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
	});

	$(document).on("change","[data-product-choice]",function(){
		UpdateOrder();
	});

	

	function UpdateOrder(){
		$('.category .slider-products li.uk-active').each(function(){
			console.log($(this).attr('data-title'));
		});
	}
});
