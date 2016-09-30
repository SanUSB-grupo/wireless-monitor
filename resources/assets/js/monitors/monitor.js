
define(['jquery'], function ($) {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = this.href.split('#');
        $('.nav a').filter('[href="#'+target[1]+'"]').tab('show');
    });

    return {
        /**
         * Fetch the monitor, based on the id.
         * @param  {integer|string} id   the monitor id
         * @param  {string} template mustache template
         * @param  {function} onSuccess  function that are called when the fetch is successful
         * @param  {function} onComplete function that are called when the fetch is completed
         * @return {undefined}
         */
        fetch: function (id, onComplete) {
            return $.ajax({
                url: '/monitor/ajax-get',
                data: {
                    id: id
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
                complete: function () {
                    onComplete();
                }
            });
        },
        /**
         * Render the monitor based on the template
         * @param  {string} template mustache template
         * @param  {object} monitor  monitor that comes from fetch
         * @return {string}
         */
        render: function (template, monitor) {
            return Mustache.render(template, monitor);
        },
        measures: function (id, limit, order, onComplete) {
            return $.ajax({
                url: '/monitor/ajax-get-measures',
                data: {
                    id: id,
                    limit: limit,
                    order: order
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
                complete: function () {
                    if (onComplete) {
                        onComplete();
                    }
                }
            });
        }
    };
});
