
$(function () {
    var $app = $('div#root-app');

    var templates = {
        temperature: $('#template-temperature').html()
    };
    $.each(templates, function (index, value) {
        Mustache.parse(value);
    });

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
            var len = list.length;
            var result = '';
            for (var i = 0; i < len; i++) {
                var element = list[i];
                element.data = JSON.parse(element.data);
                var template = templates[element.data.type];
                result += Mustache.render(template, element);
            }
            return result;
        }
    };

    monitors.fetch(function (list) {
        var result = monitors.render(list);
        $app.html(result);
    }, function () {
        console.log('loaded.');
    });
});
