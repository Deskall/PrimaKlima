$(document).ready(function(){
	$(document).on("paste","[data-referent-name]",function(e){
		e.preventDefault();
	});
});

$.validator.addMethod("data-referent-name", function(value, element,attr) {
    var referent = $("input[name='"+attr+"']").val();
   if (referent === value){
   	return true;
   }
    return false;
}, "Die beiden E-Mail-Adressen stimmen nicht überein");