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

	//Package Selection
	$(document).on("click","[data-package-choice]",function(){
		$("#Form_CheckoutForm_ProductID").val($(this).attr('data-package-choice'));
		price = parseInt($(this).attr('data-price')) * 100;
		$(".summary-package").attr('hidden','hidden');
		$("#summary-package-"+$(this).attr('data-package-choice')).attr('hidden',false);
		if ($(this).attr('data-package-choice') == 3){
			var option = $("select[name='package-option'] option:selected");
			$("#Form_CheckoutForm_OptionID").val(option.attr('value'));
			$("#summary-package-"+$(this).attr('data-package-choice')).find('td.price').text(option.attr('data-price')+' €');
			$("#summary-package-"+$(this).attr('data-package-choice')).find('td.runtime').text(option.attr('data-runtime'));
		}
		UIkit.tab('#tab-switcher').show(1);
	});

	//Pyement Method Fields
	$(document).on("change","input[name='paymentmethod']",function(){
		if ($("input[name='paymentmethod']:checked").val() == "bill"){
			$("#bill-form-container").attr('hidden',false).find('input,select').attr('required',true);
			$("#card-form-container").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden',false);
			$("#Form_CheckoutForm_action_payBill").attr('hidden',false);
		}
		else{
			$("#bill-form-container").attr('hidden','hidden').find('input, select').attr('required',false);
			$("#Form_CheckoutForm_action_payBill").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden','hidden');
			$("#card-form-container").attr('hidden',false);
		}
	
		$("#Form_CheckoutForm_PaymentType").val($("input[name='paymentmethod']:checked").val());
	});

	function getPrice(){
		return price;
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
	        	url: window.location.pathname+'/transaktion-abgeschlossen',
	          	method: 'post',
	          	data: {
	            	orderID: data.orderID,
	            	productID: $("#Form_CheckoutForm_ProductID").val(),
	            	voucherID: voucherID
	          	},
	          	dataType: 'Json'
	        }).done(function(response){
	        	if (response.status == "OK"){
	        		window.location.href = "/danke-fuer-ihre-bestellung";
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