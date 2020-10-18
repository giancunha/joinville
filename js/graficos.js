$(document).ready(function () {
    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();
    jQuery(window).resize(function() {
        delay(function() {
            m3.redraw();
        }, 200);
    }).trigger('resize');
    var m3 = new Morris.Bar({
        element: 'bar-chart',
        data: previsao,
        xkey: 'periodo',
        ykeys: yKeys,
        labels: labels,
        lineWidth: '1px',
        fillOpacity: 0.8,
        smooth: false,
        hideHover: true
    });
});
