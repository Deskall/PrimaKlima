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
		price = parseFloat($(this).attr('data-price'));
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
					$("tbody#package-summary").append('<tr><td colspan="3" class="uk-text-right">Rabatt</td><td>- '+response.NiceAmount+'</td>\
						</tr><tr><td colspan="3">&nbsp;</td><td class="uk-text-bold">'+response.price+' €</td></tr>');
					price = parseFloat(response.price);
					voucherID = response.voucherID;
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
	        }],
		  	application_context: {
			  shipping_preference: 'NO_SHIPPING'
			}
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