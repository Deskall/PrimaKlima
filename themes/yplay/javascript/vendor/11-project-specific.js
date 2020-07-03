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
		UIkit.scroll("#mobile-cart-container");
	});

	//Sticky Cart for mobile
	// UIkit.util.on("#mobile-cart-container", 'active',function(){
	// 	$("#mobile-order-preview").attr('hidden','hidden');
	// 	$(".cart-button").removeClass('uk-hidden');
	// 	$(".cart-button.hide").addClass('uk-hidden');
	// });

	//Configurator Page
	if ($('body').hasClass('ConfiguratorPage')){	
		//Initiate all
		var cart,
		products = [],
		packages = [],
		productsOfPackages = [],
		updateRun;
		
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
				$(this).parents('.category').removeClass('disabled').addClass('activated');
			}
			UpdateOrder();
		});

		//Handle the product slider
		$(document).on("click",".category:not(.disabled) .uk-slider-items li",function(){
			var slider = $(this).parents('.uk-slider');
			var index = parseInt($(this).attr('data-index')) - 1;
			UIkit.slider(slider).show(index);
		});


		
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
			UIkit.util.on("#"+$(this).attr('id'), 'itemshown', function () {
				clearTimeout(updateRun);
			   updateRun = setTimeout(UpdateOrder,200);
			});
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

	function UpdateOrderPreview(packageID, products,context){
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
		var validator = $("#Form_OrderForm").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parents(".uk-form-controls") );
			}
		});

		//Check if form error
		if ($(".message.required").length > 0){
			var tab = $(".message.required").parents('li');
			UIkit.switcher("#order-nav-switcher").show(tab.attr('data-index'));
			
		}

		
		
		$(document).on("click",".step",function(){
			if (!$(this).hasClass('backwards')){
				//Process for new customers
				var proceed = true;
				if ($(this).hasClass('customer-button')){
					proceed = false;
					$(this).addClass('is-reviewed');
					InitCustomer();
					
				}
				if (proceed) {
					//Check daten && Update Session Data
					var form = $(this).parents('form');
					var valid = form.valid();
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
					
					if (valid){
						UpdateCartData();
						UIkit.switcher("#order-nav-switcher").show($(this).attr('data-target'));
						$(':focus').blur();
						$('html, body').animate({scrollTop: $("#order-form-steps").offset().top - 110  }, 500);
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
			}
			else{
				UIkit.switcher("#order-nav-switcher").show($(this).attr('data-target'));
				$('html, body').animate({scrollTop: $("#order-form-steps").offset().top - 110  }, 500);
				$(':focus').blur();
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
			//handle pseudo-checkbox radio fields
			if ($(this).hasClass('pseudo-radio')){
				var value = $(this).attr('data-value');
				$("input[name='"+$(this).attr('name')+"']").each(function(){
					if ($(this).attr('data-value') != value){
						$(this).prop('checked',false);
					}
				});
			}

		
			$(".options input[type='checkbox']").each(function(){
				if ($(this).is(':checked')){
					if ($(this).attr('data-is-multiple')){
						var quantityInput = $(this).parents('tr').find('input.quantity');
						if(quantityInput.val() < 1 ){
							quantityInput.val(1);
						}
						quantityInput.attr('hidden',false);
						options.push({
							'code' : $(this).attr('data-value'),
							'quantity': quantityInput.val()
						});
					}
					else{
						options.push({
							'code' : $(this).attr('data-value'),
							'quantity':1
						});
					}
					
				}
				else{
					$(this).parents('tr').find('input.quantity').val(0).attr('hidden','hidden');
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
		$(".order-preview").addClass('loading').append('<div class="uk-position-center uk-position-z-index"><span data-uk-spinner="ratio: 3"></span></div>');
		$.ajax({
			url: '/shop-functions/updateCartOptions',
			method: 'POST',
			dataType: 'html',
			data: {options: options}
		}).done(function(response){
			$(".order-preview").each(function(){
				$(this).removeClass('loading');
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
		var active  = $("#order-nav-switcher li.uk-active");
		switch(li.attr('data-nav')){
			case "1":
				var index = (active) ? active.attr('data-index') : 0;
				UIkit.switcher("#order-nav-switcher").show(index);
				break;
			case "2":
				var index = (active) ? active.attr('data-index') : 4;
				UIkit.switcher("#order-nav-switcher").show(index);
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

	/**
	* if new customer, we apply specific rules
	* like aufschaltgebühr
	* like product requirements
	* ...
	*/
	function InitCustomer(){
		$.ajax({
			url: '/shop-functions/checkCustomer',
			method: 'POST',
			dataType: 'json',
			data: {isCustomer: $("input[name='ExistingCustomer']").val()}
		}).done(function(response){
			if (response.link){
				window.location.href = response.link;
			}
			else {
				$(".is-reviewed").removeClass("customer-button").trigger('click');
				UpdateCart();
			}
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


//Shopfinder
var objectsmap;
var markers = [];
var infowindow; 
var initCenter;

function initShopsMap() {
  objectsmap = new google.maps.Map(document.getElementById('googlemap_shop-finder'), {
    center: {lat: 46.8272608, lng: 8.4965408},
    zoom: 8
  });
  AddShops();
  
     // Try HTML5 geolocation.
    // if (navigator.geolocation) {
    //   navigator.geolocation.getCurrentPosition(function(position) {
    //     initCenter = {
    //       lat: position.coords.latitude,
    //       lng: position.coords.longitude
    //     };
       
    //     objectsmap.setCenter(initCenter);
       
    //   }, function() {
    //     initCenter = {
    //       lat: 46.8272608,
    //       lng: 8.4965408
    //     };
    //     objectsmap.setCenter(initCenter);
        
    //   });
    // } else {
      // // Browser doesn't support Geolocation
      // handleLocationError(false, infoWindow, objectsmap.getCenter());
      //On prend Suisse
      initCenter = {
        lat: 46.8272608,
        lng: 8.4965408
      };
      objectsmap.setCenter(initCenter);
    // }

  $("#googlemap_shop-finder").show();
 
}
function AddShops(){
  var shops = $.parseJSON($("#googlemap_shop-finder").attr('data-objects'));
  infowindow = new google.maps.InfoWindow({maxWidth: 300});
  $.each(shops,function(index,value){
    
    var position = {lat: parseFloat(value.Lat), lng: parseFloat(value.Lng)};
    var marker = new google.maps.Marker({
      position: position,
      map: objectsmap,
      title: value.Name,
      objectId: value.ID
    });
   

    markers.push(marker);
    marker.addListener('click', function() {
      var contentString = value.Content;
      infowindow.setContent(contentString);
      infowindow.open(objectsmap, marker);
    });
    var link = document.getElementById('show-marker-'+value.ID);
    google.maps.event.addDomListener(link, 'click', function() {
        var contentString = value.Content;
        infowindow.setContent(contentString);
        infowindow.open(objectsmap, marker);
    });
   
  });
}
$(document).ready(function(){
	if ($(".shop-map-container").length > 0){
		
		$('body').append('<script async defer src="//maps.google.com/maps/api/js?key=AIzaSyCbrDquBmMxiRMZz6itPir8xKX7HLa7xZE&libraries=geometry&callback=initShopsMap"></script>');

		
   
    }

    $(document).on("click","[data-search]",function(){
        var input = $("input[name='plz-search']").val();
        if (input){
            $("#reset-search").attr('hidden',false);
            $("#no-near-shops").attr('hidden','hidden');
            var url = "https://maps.googleapis.com/maps/api/geocode/json?address="+encodeURIComponent(input)+"+schweiz&key=AIzaSyA2DzCjeU3-MRVYWG2hwRxFMfMNPhwuFyU";
            $.ajax({
                url: url,
                dataType: 'json'
            }).done(function(response){
                var result = response.results[0];
                var pos = new google.maps.LatLng(result.geometry.location.lat,result.geometry.location.lng);
                objectsmap.setCenter(pos)
                objectsmap.setZoom(10);
                var i = markers.length;
                //filter Marker and list
                $.each(markers,function(index,value){

                    var distance = google.maps.geometry.spherical.computeDistanceBetween(pos,value.position);
                    if (distance > 50000){
                        markers[index].setMap(null);
                        $("#shop-"+value.objectId).attr('hidden','hidden');
                        i--;
                    }
                    else{
                        markers[index].setMap(objectsmap);
                        $("#shop-"+value.objectId).attr('hidden',false);

                    }
                });

                if( i == 0){
                    $("#no-near-shops").attr('hidden',false);
                }
            });
        }
        else{
            $("#reset-search").attr('hidden','hidden');
            $.each(markers,function(index,value){
                markers[index].setMap(objectsmap);
                $("#shop-"+value.objectId).attr('hidden',false);
                objectsmap.setCenter(initCenter);
                objectsmap.setZoom(8);
            });
        }
    });

    $(document).on("click","[data-close]",function(){
        $("input[name='plz-search']").val('');
        $("#reset-search").attr('hidden','hidden');
        $.each(markers,function(index,value){
            markers[index].setMap(objectsmap);
            $("#shop-"+value.objectId).attr('hidden',false);
            objectsmap.setCenter(initCenter);
            objectsmap.setZoom(8);
        });
    });


    //HD Smartcard
	if ($('.hdsmartcardblock').length > 0){
		var hdprice,
			subprice,
			quantity,
			smartcardoptions;

		$(document).on("change",".hdsmartcardblock input",function(){
			CalculateSmartcardPrice();
		});

		$(document).on("click",".hdsmartcardblock [data-submit-smartcard]",function(){
			$.ajax({
				url: '/shop-functions/smartcard/',
				method: 'POST',
				dataType: 'json',
				data: {options: smartcardoptions}
			}).done(function(response){
				$(this).removeClass('loading');
				if (response.link){
					window.location.href = response.link;
				}
				else{
					console.log(response.error);
				}
			});
		});

		function CalculateSmartcardPrice(){
			hdprice = 0;
			smartcardoptions = {};
			$('.hdsmartcardblock').find("tr.product").each(function(){
				$(this).find('.sub-total').empty();
				quantity = $(this).find('input').val();

				if (quantity > 0){
					smartcardoptions[$(this).attr('data-value')] = quantity;
					subprice = quantity * parseFloat($(this).attr('data-price'));
					$(this).find('.sub-total').text(printPrice(subprice));
					hdprice += subprice;
				}
			});
			$('.hdsmartcardblock').find('#total-price').text(printPrice(hdprice));
		}
	}

	//Pay TV Package
	if ($('.paytvblock').length > 0){
		var hdprice,
			subprice,
			paytvpackages;

		$(document).on("change",".paytvblock input",function(){
			CalculatePayTVPrice();
		});

		$(document).on("click",".paytvblock [data-submit-paytv]",function(){
			$.ajax({
				url: '/shop-functions/smartcard/',
				method: 'POST',
				dataType: 'json',
				data: {options: paytvpackages}
			}).done(function(response){
				$(this).removeClass('loading');
				if (response.link){
					window.location.pathname = response.link;
				}
				else{
					console.log(response.error);
				}
			});
		});

		function CalculatePayTVPrice(){
			hdprice = 0;
			paytvpackages = {};
			$('.paytvblock').find("tr.product").each(function(){
				if (!$(this).find('input') || $(this).find('input').is(':checked')){
					paytvpackages[$(this).attr('data-value')] = 1;
					hdprice += parseFloat($(this).attr('data-price'));
				}
				
			});
			$('.paytvblock').find('#total-price').text(printPrice(hdprice)+' / Mt.');
		}
	}

	function printPrice(price){
		price = price.toFixed(2);
		return 'CHF '+price;
	}

});
