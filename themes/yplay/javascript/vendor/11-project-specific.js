var screensize = $(window).width();
if (screensize < 768){
    var mobilescreen = true;
}
var isMobile = {
    Android: function() {
        return (navigator.userAgent.match(/Android/i) && mobilescreen);
    },
    BlackBerry: function() {
        return (navigator.userAgent.match(/BlackBerry/i) && mobilescreen);
    },
    iOS: function() {
        return (navigator.userAgent.match(/iPhone|iPad|iPod/i) && mobilescreen);
    },
    Opera: function() {
        return (navigator.userAgent.match(/Opera Mini/i) && mobilescreen);
    },
    Windows: function() {
        return ((navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i)) && mobilescreen);
    },
    any: function() {
        return ((isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()) && mobilescreen);
    }
};


$(document).ready(function(){
	if ($(".sidebar-menu").length > 0){
		var right = ($(".sidebar-menu").width() - $(".sidebar-menu").height()) / 2 ;
		$(".sidebar-menu").css("right", '-'+right+'px');
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

	//Toggle cart (all pages)
	$(document).on("click",".toggle-cart",function(){
		UIkit.toggle($(this).attr('data-target')).toggle();
		$(".cart-button").toggleClass('uk-hidden');
	});

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
			console.log(packages);
			
		});

		$.ajax({
			url: '/shop-functions/getActiveCart',
			dataType: 'Json'
		}).done(function(response){
			products = response;
			console.log(products);
			InitSliders(products);
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
			//activate slider
			index = 1;
			if (products[$(this).attr('data-code')]){
				$(this).find('li[data-value="'+products[$(this).attr('data-code')][0]+'"]').addClass('uk-active');
				index = parseInt($(this).find('li[data-value="'+products[$(this).attr('data-code')][0]+'"]').attr('data-index')) - 1;
			}
			else{
				if ($(this).attr('data-id') > 0){
					$(this).find('li[data-product-id="'+$(this).attr('data-id')+'"]').addClass('uk-active');
					index = parseInt($(this).find('li[data-product-id="'+$(this).attr('data-id')+'"]').attr('data-index')) - 1;
				}
			}
			UIkit.slider("#"+$(this).attr('id'),{center:true, index:index});

			//Manage state
			if ($(this).parents('.category').attr('data-disabled')){
				$(this).parents('.category').find('.no-category').prop("checked",true).parents('.category').addClass('disabled');
			}
			else{
				if (products[$(this).attr('data-code')]){
					$(this).parents('.category').find('.no-category').prop("checked",false).parents('.category').removeClass('disabled');
				}
			}
		});
		UpdateOrder();
	}

	function UpdateOrder(){
		productsOfPackages = [];
		products = [];
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
				UpdateCartSummaries();
			});
		});
	}

	function UpdateCartSummaries(){
		$(".total-monthly-price").text($("#total-monthly-price").text());
	}


	//Shop Page script
	if ($('body').hasClass('ShopPage')){

		UpdateOrder();
		InitNav();
		InitStep();
		var validator = $("#Form_OrderForm").validate();

		
		
		$(document).on("click",".step",function(){
			if (!$(this).hasClass('backwards')){
				//Check daten && Update Session Data
				var form = $(this).parents('form');
			
				if (form.valid()){
					UpdateCartData();
					UIkit.switcher("#order-nav-switcher").show($(this).attr('data-target'));
					$("#order-nav").find('li.uk-active').removeClass('uk-active');
					var nav = $("#order-nav").find('li[data-nav="'+$(this).attr('data-nav')+'"]');
					if (nav.hasClass('dk-inactive')){
						nav.removeClass('dk-inactive');
						//Update cart steps
						UpdateCartStep(nav.attr('data-nav'));
					}
					
					if (!nav.hasClass('uk-active')){
						nav.addClass('uk-active');
					}
				}
			}
			else{
				UIkit.switcher("#order-nav-switcher").show($(this).attr('data-target'));
				$("#order-nav").find('li.uk-active').removeClass('uk-active');
				var nav = $("#order-nav").find('li[data-nav="'+$(this).attr('data-nav')+'"]');
				if (nav.hasClass('dk-inactive')){
					nav.removeClass('dk-inactive');
					//Update cart steps
					UpdateCartStep(nav.attr('data-nav'));
				}
				
				if (!nav.hasClass('uk-active')){
					nav.addClass('uk-active');
				}
			}
			
		});

		$(document).on("click","#order-nav li",function(e){
			if (!$(this).hasClass('dk-inactive')){
				$("#order-nav li.uk-active").removeClass('uk-active');
				$(this).addClass('uk-active');
				switch($(this).attr('data-nav')){
					case "1":
						UIkit.switcher("#order-nav-switcher").show(0);
						break;
					case "2":
						UIkit.switcher("#order-nav-switcher").show(3);
						break;
					case "3":
						UIkit.switcher("#order-nav-switcher").show(5);
						break;
				}
			}
		});


		$(document).on("click",".customer-button",function(){
			$("input[name='ExistingCustomer']").val($(this).attr('data-value'));
		});

		$(document).on("change","input[name='BillSameAddress']",function(){
			UIkit.toggle($("#bill-fields")).toggle();
		});

		$(document).on("change","input[name='PhoneOption']",function(){
			$("#existing-phone,#wish-phone").attr('hidden','hidden').find('input').attr('required',false);
			switch($("input[name='PhoneOption']:checked").attr('value')){
				case "existing":
					$("#existing-phone").attr('hidden',false).find('input').attr('required','required');
					break;
				case "wish":
					$("#wish-phone").attr('hidden',false).find('input').attr('required','required');
					break;
			}
			UIkit.update(document.body, type = 'update');
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

		$(document).on("change","input[name='UnknownGlasfaserdose']",function(){
			if ($(this).is(':checked')){
				$("input[name='Glasfaserdose']").attr('required',false);
			}
			else{
				$("input[name='Glasfaserdose']").attr('required','required');
				$("input[name='Glasfaserdose']").next('.error').hide();
			}
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
				UpdateCartSummaries();
			});
		});
	}

	function UpdateCartStep(step){
		$.ajax({
			url: '/shop-functions/updateCartStep',
			method: 'POST',
			data: {step: step}
		});
	}

	function UpdateCartData(){
		var data = $("form#Form_OrderForm").serialize();
		$.ajax({
			url: '/shop-functions/updateCartData',
			method: 'POST',
			data: {form: data}
		});
	}

	function InitNav(){
		var li = $("#order-nav li.uk-active");
		switch(li.attr('data-nav')){
			case "1":
				UIkit.switcher("#order-nav-switcher").show(0);
				break;
			case "2":
				UIkit.switcher("#order-nav-switcher").show(3);
				break;
			case "3":
				UIkit.switcher("#order-nav-switcher").show(5);
				break;
		}
	}

	function InitStep(){
		var i = 0;
		$("#order-form-steps > li").each(function(){
			$(this).attr('data-index',i);
			$(this).find('.step.forward').attr('data-target',i+1);
			$(this).find('.step.backwards').attr('data-target',i-1);
			i++;
		});
	}

});


//Mobile related
$(document).ready(function(){
	if (!isMobile.any()){
		$(".dk-transition-toggle-not-mobile").addClass('uk-transition-toggle');
	}
	if (isMobile.any()){
		//ScrollUp
		var screenHeight = $(window).height();
		$(window).scroll(function(){
			console.log('ici');
			console.log($(this).scrollTop());
			if ($(this).scrollTop() > screenHeight){
				$(".scrollup-container").show();
				setTimeout(function(){
					$(".scrollup-container").hide();
				},2000);
			}
			else{
				$(".scrollup-container").hide();
			}
		});
	}
});