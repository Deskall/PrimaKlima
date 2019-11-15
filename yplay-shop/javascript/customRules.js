$.validator.addMethod("maxDate", function(value, element,attr) {
    var maxDate = new Date(attr);
    var inputDate = new Date(value);
    if (inputDate > maxDate)
        return false;
    return true;
}, 'Sie müssen mindestens 18 Jahre alt sein, um auf unserer Website bestellen zu können');
$.validator.addMethod("minDate", function(value, element,attr) {
    var maxDate = new Date(attr);
    var inputDate = new Date(value);
    if (inputDate < minDate)
        return false;
    return true;
}, 'Ungültiges Datum');



$.validator.addMethod("intlTelNumber", function(value, element) {
    phone_number = value.replace( /\s+/g, "" );
    if (phone_number){
    	return 
	    phone_number.match( /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{1,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/ ) ||
	    phone_number.match( /^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/ )
	    ;
    }
    return true;
}, "Bitte geben Sie eine gültige schweizer oder deutsche Telefonnummer ein");