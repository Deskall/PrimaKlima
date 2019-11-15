$.validator.addMethod("maxDate", function(value, element,attr) {
console.log(attr);
    var maxDate = new Date(attr);
    var inputDate = new Date(value);
    console.log(maxDate);
    if (inputDate > maxDate)
        return false;
    return true;
}, 'Sie müssen mindestens 18 Jahre alt sein, um auf unserer Website bestellen zu können');