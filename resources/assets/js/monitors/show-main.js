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
})

require(['jquery', 'monitors/monitor'], function ($, monitor) {
    var $type = $('input#type');
    require(['monitors/components/' + $type.val()]);
});
