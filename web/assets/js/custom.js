function animateToValue(value, id_layout) {
    $({someValue: 0}).animate({someValue: value}, {
        duration: 2000,
        easing: 'swing',
        step: function () {
            $('#' + id_layout).text(commaSeparateNumber(Math.round(this.someValue)));
        }
    });
}

function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
    return val;
}
