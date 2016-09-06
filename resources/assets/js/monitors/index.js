
$(function () {
    var $app = $('div#root-app');
    var templates = {};

    /**
     * load template from cache or URL based on the type
     * @param  {[type]} type [description]
     * @return {[type]}      [description]
     */
    function loadTemplate(type) {
        if (templates['type']) {
            return templates['type'];
        }
        return templates['type'] = $.get('/templates/temperature/index.mustache')
            .pipe(function (res) {
                // compile and save to the cache
                Mustache.parse(res)
                return templates['type'] = res;
            });
    }

    var monitors = {
        fetch: function (onSuccess, onComplete) {
            $.ajax({
                url: '/monitor/ajax-list',
                success: function (json) {
                    if (json.ok) {
                        onSuccess(json.list);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                complete: function () {
                    onComplete();
                }
            });
        },
        render: function (list) {
            list = list || [];
            list.forEach(function (element, index) {
                var promise = loadTemplate(element.data.type);
                $.when(promise).done(function (res) {
                    var result = Mustache.render(res, element);
                    $app.append(result);
                });
            });
        }
    };

    monitors.fetch(function (list) {
        $app.html(''); // clear loading text
        var result = monitors.render(list);
    }, function () {
        console.log('loaded.');
    });
});
