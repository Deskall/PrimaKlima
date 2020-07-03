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
}, "Bitte geben Sie eine gültige schweizer oder deutsche Telefonnummer ein");