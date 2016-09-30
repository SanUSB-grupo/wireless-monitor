require.config({
    baseUrl: '/js/',
    paths: {
    }
});

define('jquery', [], function() {
    return jQuery;
});

define('moment', [], function () {
    return moment;
});

define('Chartist', [], function () {
    return Chartist;
});

define('Chart', [], function () {
    return Chart;
});

require(['jquery', 'monitors/monitor'], function ($, monitor) {
    var $type = $('input#type');
    require(['monitors/components/' + $type.val()], function () {
        console.info('Component', $type.val(), 'ready.');
    }, function (err) {
        console.warn('Component', $type.val(), 'not found.', err);
    });
});
