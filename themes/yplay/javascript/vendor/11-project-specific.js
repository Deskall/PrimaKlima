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

	//Configurator Page
	if ($('body').hasClass('ConfiguratorPage')){	
		//Initiate all
		var cart;
		var products = [];
		var packages = [];
		var productsOfPackages = [];
		var hasEvent = false;

		

		
		
		var url = window.location.pathname;
		$.ajax({
			url: '/shop-functions/fetchPackages',
			dataType: 'Json'
		}).done(function(response){
			packages = response;
			//fetch the cart
			$.ajax({
				url: '/shop-functions/getActiveCart',
				dataType: 'Json'
			}).done(function(response){
				products = response;
				InitSliders(products);
			});
		});

		

		$(document).on("change","[data-product-choice]",function(){
			UpdateOrder();
		});

		$(".no-category").each(function(){
			if ($(this).is(':checked')){
				$(this).parents('.category').addClass('disabled');
			}
			else{
				$(this).parents('.category').removeClass('disabled');
			}
		});

		$(document).on("change",".no-category",function(){
			if ($(this).is(':checked')){
				$(this).parents('.category').addClass('disabled');
			}
			else{
				$(this).parents('.category').removeClass('disabled');
			}
			UpdateOrder();
		});

		//Handle the product slider
		$(document).on("click",".category:not(.disabled) .uk-slider-items li",function(){
			var slider = $(this).parents('.uk-slider');
			var index = parseInt($(this).attr('data-index')) - 1;
			UIkit.slider(slider).show(index);
			if (!hasEvent){
				UIkit.util.on(".slider-products",'itemshown',function(){
					$(this).parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
					hasEvent  = true;
				});
			}
		});
	}


	function InitSliders(products){
		var index;
		var options;
		$(".slider-products").each(function(){
			index = 1;
			if (products[$(this).attr('data-code')]){
				index = parseInt($(this).find('li[data-value="'+products[$(this).attr('data-code')][0]+'"]').attr('data-index')) - 1;
				$(this).parents('.category').find('.no-category').prop("checked",false).parents('.category').removeClass('disabled');
			}
			else{
				if ($(this).attr('data-id') > 0){
					index = parseInt($(this).find('li[data-product-id="'+$(this).attr('data-id')+'"]').attr('data-index')) - 1;
				}
			}
			UIkit.slider("#"+$(this).attr('id'),{center:true, index:index});
		});
		UpdateOrder();
	}


	function UpdateOrder(){
		productsOfPackages = [];
		products = [];
		var package;
		var chosenPackageID = 0;
		$('.category:not(.disabled) .slider-packages .uk-slider-items li.uk-active').each(function(){
			productsOfPackages.push($(this).attr('data-value'));
		});
		$('.category:not(.disabled) .slider-products .uk-slider-items li.uk-active').each(function(){
			products.push($(this).attr('data-value'));
		});
		//Compare to see if any package matches the selected products
		$.each(packages,function(i,v){
			if (compareArrays(v['Products'],productsOfPackages)){
				chosenPackageID = v['ID'];
				return false;
			}
		});

		UpdateOrderPreview(chosenPackageID, products);
	}

	function compareArrays(arr1, arr2) {
	    return $(arr1).not(arr2).length == 0 && $(arr2).not(arr1).length == 0
	};

	function UpdateOrderPreview(packageID, products){
		$.ajax({
			url: '/shop-functions/fetchCart',
			method: 'POST',
			dataType: 'html',
			data: {packageID: packageID, products: products}
		}).done(function(response){
			$(".order-preview").each(function(){
				$(this).empty().append(response);
			});
		});
	}


	//Shop Page script
	if ($('body').hasClass('ShopPage')){

		UpdateOrder();
		
		$(document).on("click",".step",function(){
			UIkit.switcher("#order-nav-switcher").show($(this).attr('data-target'));
			$("#order-nav").find('li.uk-active').removeClass('uk-active');
			var nav = $("#order-nav").find('li[data-nav="'+$(this).attr('data-nav')+'"]');
			nav.removeClass('dk-inactive');
			if (!nav.hasClass('uk-active')){
				nav.addClass('uk-active');
			}
		});

		$(document).on("change","input[name='BillSameAddress']",function(){
			if ($(this).is(':checked')){
				$("li[data-step='address']").find('.forward').attr('data-target','3').attr('data-nav','2');
				$("li[data-step='phone']").find('.backward').attr('data-target','1');
			}
			else{
				$("li[data-step='address']").find('.forward').attr('data-target','2').attr('data-nav','1');
				$("li[data-step='phone']").find('.backward').attr('data-target','2');
			}
		});

		$(document).on("click","li[data-step='options'] tr td:not(:first-child)",function(e){

			if ($(this).parents('tr').find('input').is(":checked")){
				$(this).parents('tr').find('input').prop("checked",false).trigger("change");
			}
			else{
				$(this).parents('tr').find('input').prop("checked",true).trigger("change");
			}
		});

		$(document).on("change",".options input",function(){
			var options = [];
			$(".options input").each(function(){
				if ($(this).is(':checked')){
					options.push($(this).attr('data-value'));
				}
			});
			UpdateCart(options);
		});
	}

	function UpdateCart(options){
		$.ajax({
			url: '/shop-functions/updateCartOptions',
			method: 'POST',
			dataType: 'html',
			data: {options: options}
		}).done(function(response){
			$(".order-preview").each(function(){
				$(this).empty().append(response);
			});
		});
	}

});


