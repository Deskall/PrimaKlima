$.validator.addMethod("maxDate", function(value, element,attr) {
    var maxDate = new Date(attr);
    var inputDate = new Date(value);
    if (value && inputDate > maxDate)
        return false;
    return true;
}, 'Sie müssen mindestens 18 Jahre alt sein, um auf unserer Website bestellen zu können');
$.validator.addMethod("minDate", function(value, element,attr) {
    var minDate = new Date(attr);
    var inputDate = new Date(value);
    if (value && inputDate < minDate)
        return false;
    return true;
}, 'Ungültiges Datum');



$.validator.addMethod("intlTelNumber", function(value, element) {
    phone_number = value.replace( /\s+/g, "" );
    if (phone_number){
    	return phone_number.match(/^(\+41|0041|0){1}(\(0\))?[0-9]{9}$/) ||
        phone_number.match(/^(\+49|0049|0){1}(\(0\))?[0-9]{10}$/)
	    ;
    }
    return true;
}, "Bitte geben Sie eine gültige schweizer oder deutsche Telefonnummer ein");

$.validator.addMethod("validateEmail", function(value, element) {
    return value == $("input[name='Email']").val();
}, "E-Mail-Adressen stimmen nicht überein");