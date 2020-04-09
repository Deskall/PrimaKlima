$(document).ready(function(){
	
	//if form not valid we go to correct tab
	if ($("#Form_RegisterForm").length > 0 && $("#Form_RegisterForm").find('.message.validation').length > 0){
		//search for errors
		var switcher = $('#tab-switcher');
		var errorMessage = $("#Form_RegisterForm").find('.message.validation');
		var index = parseInt(errorMessage.parents('li.account-tab').attr('data-index'));
		//Update Package
		$("#summary-package-"+$("#Form_RegisterForm_ProductID").val()).attr('hidden',false);
		UIkit.tab(switcher).show(index);
	}

	$("#Form_RegisterForm_CustomerFields_Holder input,#Form_RegisterForm_CustomerFields_Holder select").on("change",function(){
		UpdateAddress();
	});
		
	function UpdateAddress(){
		var html = '<p>';
		if ($("input[name='Company']").val()){
			html += $("input[name='Company']").val()+'<br>';
		}
		html += $("select[name='Gender']").val()+' '+$("input[name='Vorname']").val()+' '+$("input[name='Name']").val()+'<br>';
		html += $("input[name='Address']").val()+'<br>';
		html += $("input[name='PostalCode']").val()+' '+$("input[name='City']").val()+'<br>';
		html += $("select[name='Country'] option:selected").text();
		html += '</p>';

		$("#customer-address").html(html);
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
	

	//Pyement Method Fields
	$(document).on("change","input[name='PaymentMethod']",function(){
		if ($("input[name='PaymentMethod']:checked").val() == "bill"){
			$("#card-form-container").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden',false);
			$("#Form_RegisterForm_action_doRegisterBill").attr('hidden',false);
			$("#payment-type").html('<p>'+$("label[for='bill-choice']").html()+'</p>');
		}
		else if ( $("input[name='PaymentMethod']:checked").val() == "cash"){
			$("#card-form-container").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden',false);
			$("#Form_RegisterForm_action_doRegisterBill").attr('hidden',false);
			$("#payment-type").html('<p>'+$("label[for='cash-choice']").html()+'</p>');
		}
		else{
			$("#Form_RegisterForm_action_doRegisterBill").attr('hidden','hidden');
			$("#summary-bill-container").attr('hidden','hidden');
			$("#card-form-container").attr('hidden',false);
			$("#payment-type").html('<p>'+$("label[for='online-choice']").html()+'</p>');
		}
	
		$("#Form_RegisterForm_PaymentType").val($("input[name='PaymentMethod']:checked").val());
	});


	function UpdateOrderSummary(){
		//ici ajouter un
		$.ajax({
			url: '/kurse/updateCartSummary',
			method: 'POST',
			dataType: 'html'
		}).done(function(response){
			$(".summary-products").replaceWith(response);
		});
	}

	function UpdateCartStep(){
		var form = $("#Form_CheckoutForm");
		$.ajax({
			url: '/kurse/updateCartData',
			method: 'POST',
			dataType: 'html',
			data: {form: form.serialize()}
		}).done(function(response){
			$(".summary-products").each(function(){
				$(this).empty().append(response);
			});
		});
	}

	//Voucher
	$(document).on("click","[data-check-voucher]",function(){
		$.post({
			url: cleanUrl(window.location.pathname)+'VoucherForm',
			data:{code: $("input[name='voucher']").val(), event: $("#Form_RegisterForm_DateID").val() },
	        dataType: 'Json'
		}).done(function(response){
			if (response.status == "OK"){
				UIkit.modal.alert(response.message).then(function() {
					UpdateOrderSummary();
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
		return $("#full-total-price").attr('data-price');
	}

	function cleanUrl(url){
		url = (url.substr(url.length-1,1) == "/") ? url : url+"/";
		return url;
	}

	//PayPal
	if ($('#paypal-button-container').length > 0){
		var paypaloptions = {
	      	intent: 'CAPTURE',
	  	    payer: {
	  	        name: {
	  	          given_name: $("input[name='FirstName']").val(),
	  	          surname: $("input[name='Name']").val()
	  	        },
	  	        address: {
	  	          address_line_1: $("input[name='Street']").val(),
	  	          address_line_2: $("input[name='Address']").val(),
	  	          admin_area_2: $("input[name='City']").val(),
	  	          admin_area_1: $("input[name='Region']").val(),
	  	          postal_code: $("input[name='PostalCode']").val(),
	  	          country_code: $("select[name='Country']").val().toUpperCase()
	  	        },
	  	        email_address: $("input[name='Email']").val(),
	  	        phone: {
	  	          phone_number: {
	  	            national_number: $("input[name='Phone']").val()
	  	          }
	  	        }
	  	    },
	  	    purchase_units: [
	  	        {
	  	          amount: {
	  	            value: getPrice(),
	  	            currency_code: 'CHF'
	  	          }
	  	        }
	  	    ]
	    };
	    
		paypal.Buttons({
	    createOrder: function(data, actions) {
	      return actions.order.create(paypaloptions);
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
	            	dateID: $("input[name='DateID']").val()
	          	},
	          	dataType: 'Json'
	        }).done(function(response){
	        	
	        	if (response.status == "OK"){
	        		window.location.href = response.redirecturl;
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