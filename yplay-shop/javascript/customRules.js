$.validator.addMethod("maxDate", function(value, element) {
    var curDate = new Date();
    var inputDate = new Date(value);
    console.log(inputDate);
    if (inputDate < curDate)
        return true;
    return false;
}, 'Sie müssen mindestens 18 Jahre alt sein, um auf unserer Website bestellen zu können');