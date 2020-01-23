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
		$(document).on("click swipeleft swiperight",".category:not(.disabled) .uk-slider-items li",function(){
			var slider = $(this).parents('.uk-slider');
			var index = parseInt($(this).attr('data-index')) - 1;
			UIkit.slider(slider).show(index);
			// $(this).parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
		});
		// $(document).on("click",".category:not(.disabled) .uk-slider-nav li",function(){
		// 	$(this).parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
		// });
		// $(document).on("click",".category:not(.disabled) [data-uk-slider-item]",function(){
		// 	$(this).parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
		// });

		//Handle the category Switcher
		$(document).on("click",".category .switch",function(){
			var input = $(this).parents('.category').find('.no-category');
			if (input.is(':checked')){
				input.prop('checked',false).trigger('change');
			}
			else{
				input.prop('checked',true).trigger('change');
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

		UIkit.util.on(".slider-products",'itemshown',function(){
			if (hasEvent){
				console.log(hasEvent);
				$(this).parents('.category').find('[data-product-choice]').val($(this).attr('data-value')).trigger('change');
			}
		});
		hasEvent = true;
		UpdateOrder();
		$("#loading-block").remove();
		$("#products-hidden-container").slideDown();
		
		
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
		//ici ajouter un
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
			if (packageID > 0 || products.length > 0 ){
				$("#mobile-cart-container").attr('hidden',false);
			}
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

		//Check if form error
		if ($(".message.required").length > 0){
			var tab = $(".message.required").parents('li');
			UIkit.switcher("#order-nav-switcher").show(tab.attr('data-index'));
			
		}

		
		
		$(document).on("click",".step",function(){
			if (!$(this).hasClass('backwards')){
				//Special case for birthdate
				if ($(this).parents('[data-step]').attr('data-step') == "step-1"){
					if ($("input[name='Birthdate']").val() == ""){
						$("#birthdate-empty").attr('hidden',false);
						return false;
					}
					if ($("input[name='Birthdate']").hasClass("error")){
						return false;
					}
				}
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
						UIkit.switcher("#order-nav-switcher").show(4);
						break;
					case "3":
						var count = parseInt($("#order-form-steps > li").length - 1);
						UIkit.switcher("#order-nav-switcher").show(count);
						break;
				}
			}
		});


		$(document).on("click",".customer-button",function(){
			$("input[name='ExistingCustomer']").val($(this).attr('data-value'));
		});

		$(document).on("change","input[name='BillSameAddress']",function(){
			if ($(this).is(':checked')){
				$("#bill-fields").attr('hidden','hidden');
			}
			else{
				$("#bill-fields").attr('hidden',false);
			}
		});

		$(document).on("change keypress keyup","input[name='Birthday']", function(){

			if($(this).val().length == 2){
				$("input[name='BirthMonth']").focus();
			}
		});
		$(document).on("change keypress keyup","input[name='BirthMonth']", function(){
			if($(this).val().length == 2){
				$("input[name='BirthYear']").focus();
			}
		});

		$(document).on("change","input[name='BirthMonth'],input[name='Birthday'],input[name='BirthYear']",function(){
			$("#birthdate-error").attr('hidden','hidden');
			$("#birthdate-empty").attr('hidden','hidden');
			$("input[name='Birthdate']").removeClass('error');
			var day = parseInt($("input[name='Birthday']").val());
			var month = parseInt($("input[name='BirthMonth']").val());
			var year = parseInt($("input[name='BirthYear']").val());
			if (day && month && year){
				var birthdate = new Date(year, month - 1, day);
				var setDate = new Date(year + 18, month - 1, day);
				var today = new Date();
				if (setDate > today){
					$("#birthdate-error").attr('hidden',false);
					$("input[name='Birthdate']").addClass('error');
				}
				else{
					$("input[name='Birthdate']").val(year+'/'+month+'/'+day);
				}
			}
			else{
				$("#birthdate-empty").attr('hidden',false);
				$("input[name='Birthdate']").addClass('error');
			}
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
				UIkit.switcher("#order-nav-switcher").show(4);
				break;
			case "3":
				var count = parseInt($("#order-form-steps > li").length - 1);
				UIkit.switcher("#order-nav-switcher").show(count);
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
			if ($(this).scrollTop() > screenHeight){
				$(".scrollup-container").show();
			}
			else{
				$(".scrollup-container").hide();
			}
		});
	}
});