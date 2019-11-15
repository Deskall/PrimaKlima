$.validator.addMethod("maxDate", function(value, element) {
	
    var maxDate = new Date();
    var inputDate = new Date(value);
    console.log(element);
    if (inputDate > maxDate)
        return false;
    return true;
}, 'Sie müssen mindestens 18 Jahre alt sein, um auf unserer Website bestellen zu können');