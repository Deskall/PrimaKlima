$(document).ready(function(){
	$(document).on("paste","[data-referent-name]",function(e){
		e.preventDefault();
	});
});

$.validator.addMethod("data-referent-name", function(value, element) {
    console.log(value);
    console.log(element.attr('data-referent-name'));
    return false;
}, "Bitte geben Sie eine gültige schweizer oder deutsche Telefonnummer ein");