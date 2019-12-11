$(document).ready(function(){

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

	//Bill Fields
	$(document).on("change","input[name='paymentmethod']",function(){
		if ($("input[name='paymentmethod']:checked").val() == "bill"){
			$("#bill-form-container").attr('hidden',false).find('input,select').attr('required',true);
		}
		else{
			$("#bill-form-container").attr('hidden','hidden').find('input, select').attr('required',false);
			UIkit.tab('#tab-switcher').show(2);
		}
		$("#bill-form-container").next('div').attr('hidden',false);
		$("#Form_CheckoutForm_PaymentType").val($("input[name='paymentmethod']:checked").val());
	});



	//PayPal
	if ($('#paypal-button-container').length > 0){
		paypal.Buttons({
	    createOrder: function(data, actions) {
	      return actions.order.create({
	        purchase_units: [{
	          amount: {
	            value: UpdateTotalPrice()
	          }
	        }]
	      });
	    },
	    onApprove: function(data, actions) {
	      return actions.order.capture().then(function(details) {
	        UIkit.modal.alert('Ihre Zahlung wurde berücksichtigt. Sie werden in wenigen Augenblicken weitergeleitet ...');
	        // Call your server to save the transaction
	        $.ajax({
	        	url: '/shop/transaktion-abgeschlossen',
	          	method: 'post',
	          	data: {
	            	orderID: data.orderID,
	            	productID: $("#product").attr('data-product-id'),
	            	quantity: $("input[name='quantity']").val(),
	            	voucherID: voucherID
	          	},
	          	dataType: 'Json'
	        }).done(function(response){
	        	if (response.status == "OK"){
	        		window.location.href = "/shop/bestellung-bestaetigt/";
	        	}
	        	else{
	        		 UIkit.modal.alert('Ein Fehler ist aufgetreten');
	        	}
	        }).fail(function(data){
	        	UIkit.modal.alert('Ein Fehler ist aufgetreten');
	        });
	      });
	    }
	  }).render('#paypal-button-container');
	}
});