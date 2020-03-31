$(document).ready(function(){
	//if form not valid we go to correct tab
	if ($("#Form_CheckoutForm").length > 0 && $("#Form_CheckoutForm").find('.message.validation').length > 0){
		//search for errors
		var switcher = $('#tab-switcher');
		var errorMessage = $("#Form_CheckoutForm").find('.message.validation');
		var index = parseInt(errorMessage.parents('li.account-tab').attr('data-index'));
		//Update Package
		$("#summary-package-"+$("#Form_CheckoutForm_ProductID").val()).attr('hidden',false);
		UIkit.tab(switcher).show(index);
	}

	$(document).on("change","input[name='DeliverySameAddress']",function(){
		if ($(this).is(':checked')){
			$("#delivery-form-container").attr('hidden',false);
		}
		else{
			$("#delivery-form-container").attr('hidden','hidden');
		}
	});


	//Toggle cart (all pages)
	$(document).on("click",".toggle-cart",function(){
		$("#cart-container").toggleClass('uk-hidden');
	});

	$(document).on("click",".add-to-cart",function(){
		UpdateOrderPreview($(this).attr('data-product-id'),1);
	});

	$(document).on("change","input[data-quantity]",function(){
		UpdateOrderPreview($(this).attr('data-quantity'),$(this).val(), 'checkout');
		UpdateCartSummary();
	});

	$(document).on("click","[data-remove-product]",function(){
		productID = $(this).attr('data-remove-product');
		$.ajax({
			url: '/shop/removeFromCart',
			method: 'POST',
			dataType: 'html',
			data: {productID: productID}
		}).done(function(response){
			$(".order-preview").empty().append(response);
		});
	});

	$(document).on("click","[data-step='forward']",function(){
		UpdateCartStep();
	});

	
		
	
		
		
	


	function UpdateOrderPreview(productID,quantity,context = null){
		//ici ajouter un
		$.ajax({
			url: '/shop/updateCart',
			method: 'POST',
			dataType: 'html',
			data: {productID: productID,quantity: quantity, context: context}
		}).done(function(response){
			if (context == "checkout"){
				$(".order-preview").each(function(){
					$(this).empty().append(response);
				});
			}
			else{
				$("#cart-container").replaceWith(response);
			}
		});
	}

	function UpdateOrderSummary(){
		//ici ajouter un
		$.ajax({
			url: '/shop/updateCartSummary',
			method: 'POST',
			dataType: 'html'
		}).done(function(response){
			$(".order-summary").replaceWith(response);
		});
	}

	function UpdateCartStep(){
		var form = $("#Form_CheckoutForm");
		$.ajax({
			url: '/shop/updateCartData',
			method: 'POST',
			dataType: 'html',
			data: {form: form.serialize()}
		}).done(function(response){
			$(".summary-products").each(function(){
				$(this).empty().append(response);
			});
		});
	}


	//Steps
	$(document).on("click","[data-step]",function(){
		var switcher = $('#tab-switcher');
		var tab = $(this).parents('li.account-tab');
		var form = $(this).parents('form');
		var index = parseInt(tab.attr('data-index'));
		if ($(this).attr('data-step') == "backward"){
			UIkit.tab(switcher).show(index-1);
		}
		if (form.valid() && $(this).attr('data-step') == "forward"){
			UIkit.tab(switcher).show(index+1);
		}
	});
	
	var price,
	voucherID;

	//Pyement Method Fields
	$(document).on("change","input[name='PaymentMethod']",function(){
		if ($("input[name='PaymentMethod']:checked").val() == "bill"){
			$("#bill-form-container").attr('hidden',false).find('input[data-required],select[data-required]').attr('required',true);
			$("#card-form-container").attr('hidden','hidden');
			$("#Form_CheckoutForm_DeliverySameAddress_Holder").attr("hidden",false);
			$("#summary-bill-container").attr('hidden',false);
			$("#Form_CheckoutForm_action_payBill").attr('hidden',false);
		}
		else if ( $("input[name='PaymentMethod']:checked").val() == "cash"){
			$("#bill-form-container").attr('hidden',false);
			$("#Form_CheckoutForm_DeliverySameAddress_Holder").attr("hidden","hidden");
			$("#card-form-container").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden',false);
			$("#Form_CheckoutForm_action_payBill").attr('hidden',false);
		}
		else{
			$("#bill-form-container").attr('hidden','hidden').find('input[data-required],select[data-required]').attr('required',false);
			$("#Form_CheckoutForm_action_payBill").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden','hidden');
			$("#card-form-container").attr('hidden',false);
		}
	
		$("#Form_CheckoutForm_PaymentType").val($("input[name='PaymentMethod']:checked").val());
	});

	//Voucher
	$(document).on("click","[data-check-voucher]",function(){
		$.post({
			url: cleanUrl(window.location.pathname)+'VoucherForm',
			data:{code: $("input[name='voucher']").val(), package: $("#Form_CheckoutForm_ProductID").val() },
	        dataType: 'Json'
		}).done(function(response){
			if (response.status == "OK"){
				UIkit.modal.alert(response.message).then(function() {
					$("input[name='VoucherID']").val(response.voucherID);
					
				});
			}
			else{
				if (response.message){
					UIkit.modal.alert(response.message);
				}
			}
		}).fail(function(){
			UIkit.modal.alert('Ein Fehler ist aufgetreten').then(function() {
				window.location.reload();
			});
		});
	});

	function getPrice(){
		return price;
	}

	function cleanUrl(url){
		url = (url.substr(url.length-1,1) == "/") ? url : url+"/";
		return url;
	}

	//PayPal
	if ($('#paypal-button-container').length > 0){
		paypal.Buttons({
	    createOrder: function(data, actions) {
	      return actions.order.create({
	        purchase_units: [{
	          amount: {
	            value: getPrice()
	          }
	        }]
	      });
	    },
	    onApprove: function(data, actions) {
	    	$('#paypal-button-container').hide().after('<p>Zahlung in Bearbeitung, bitte haben Sie einen Moment Geduld.</p><p>Bitte schließen Sie die Seite nicht und laden Sie sie nicht erneut.</p>');
	      return actions.order.capture().then(function(details) {
	        UIkit.modal.alert('Ihre Zahlung wurde berücksichtigt. Sie werden in wenigen Augenblicken weitergeleitet ...');
	        // Call your server to save the transaction
	        $.ajax({
	        	url: cleanUrl(window.location.pathname)+'transaktion-abgeschlossen',
	          	method: 'post',
	          	data: {
	            	orderID: data.orderID,
	            	productID: $("#Form_CheckoutForm_ProductID").val(),
	            	voucherID: voucherID,
	          	},
	          	dataType: 'Json'
	        }).done(function(response){
	        	if (response.status == "OK"){
	        		window.location.href = "/danke-fuer-ihre-bestellung";
	        	}
	        	else{
	        		 UIkit.modal.alert('Ein Fehler ist aufgetreten').then(function() {
	        		 	window.location.reload();
	        		 });
	        	}
	        }).fail(function(data){
	        	UIkit.modal.alert('Ein Fehler ist aufgetreten').then(function() {
	        		 	window.location.reload();
	        		 });
	        });
	      });
	    }
	  }).render('#paypal-button-container');
	}
});