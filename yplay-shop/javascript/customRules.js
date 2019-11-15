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