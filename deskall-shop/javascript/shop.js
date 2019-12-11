$(document).ready(function(){

	//Steps
	$(document).on("click","[data-step]",function(){
		var switcher = $(this).parents('.uk-switcher');
		var tab = $(this).parents('li.account-tab');
		var index = parseInt(tab.attr('data-index'));
		if ($(this).attr('data-step') == "backward"){
			UIkit.switcher(switcher).show(index-1);
		}
		if ($(this).attr('data-step') == "forward"){
			UIkit.switcher(switcher).show(index+1);
		}
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