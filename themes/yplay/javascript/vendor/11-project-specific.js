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
	//set up the products
	var products = [];
	//we fetch the packages
	var packages = [];
	var productsOfPackages = [];
	var url = window.location.pathname;
	$.ajax({
		url: '/shop-functions/fetchPackages',
		dataType: 'Json'
	}).done(function(response){
		packages = response;
		//Init Order
		UpdateOrder();
	});

	

	
	
	//Handle the product slider
	$(document).on("click",".category .uk-slider-items li",function(){
		var slider = $(this).parents('.uk-slider');
		var index = parseInt($(this).attr('data-index')) - 1;
		UIkit.slider(slider).show(index);
		UIkit.util.on(slider,'itemshown',function(){
			slider.parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
		});
	});

	$(document).on("change","[data-product-choice]",function(){
		UpdateOrder();
	});

	

	function UpdateOrder(){
		productsOfPackages = [];
		products = [];
		var package;
		var chosenPackage;
		$('.category .slider-packages .uk-slider-items li.uk-active').each(function(){
			productsOfPackages.push($(this).attr('data-value'));
		});
		$('.category .slider-products .uk-slider-items li.uk-active').each(function(){
			products.push($(this));
		});
		//Compare to see if any package matches the selected products
		$.each(packages,function(i,v){
			if (compareArrays(v['Products'],productsOfPackages)){
				chosenPackage = v;
				return false;
			}
		});


		UpdateOrderPreview(chosenPackage, products);
	}

	function compareArrays(arr1, arr2) {
	    return $(arr1).not(arr2).length == 0 && $(arr2).not(arr1).length == 0
	};

	function UpdateOrderPreview(package, products){
		$('.order-preview #monthly-costs tbody').empty();
		$('.order-preview #unique-costs tbody').empty();
		var totalMonthly = 0;
		var totalUnique = 0;

		//If package found we fill it.
		if (package){
			if (package['Price'] > 0){
				totalMonthly += parseFloat(package['Price']);
				$('.order-preview #monthly-costs tbody').append('<tr><td class="uk-table-expand">'+package['Title']+'</td><td class="uk-text-right">CHF '+package['Price']+' / Mt.</td></tr>');
			}
			if (package['UniquePrice'] > 0){
				totalUnique += parseFloat(package['UniquePrice']);
				var UniquePriceLabel = (package['UniquePriceLabel']) ? package['UniquePriceLabel'] : package['Title'];
				$('.order-preview #unique-costs tbody').append('<tr><td class="uk-table-expand">'+UniquePriceLabel+'</td><td class="uk-text-right">CHF '+package['UniquePrice']+' / Mt.</td></tr>');
			}
			if (package['ActivationPrice'] > 0){
				totalUnique += parseFloat(package['ActivationPrice']);
				var ActivationPriceLabel = (package['ActivationPriceLabel']) ? package['ActivationPriceLabel'] : package['Title'];
				$('.order-preview #unique-costs tbody').append('<tr><td class="uk-table-expand">'+ActivationPriceLabel+'</td><td class="uk-text-right">CHF '+package['ActivationPrice']+' / Mt.</td></tr>');
			}
			
		}
		else{

		}

		$('#total-monthly-price').text(printPrice(totalMonthly)+' / Mt.');
		$('#total-unique-price').text(printPrice(totalUnique));
	}

	function printPrice(price){
		price = parseFloat(price);
		if (price % 1 != 0){
			return 'CHF '+price;
		}
		return 'CHF '+parseInt(price)+'.-';
	}
});

