
$(function () {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = this.href.split('#');
        $('.nav a').filter('[href="#'+target[1]+'"]').tab('show');
    });

    var $app = $('div#monitor-view');

    var templates = {
        temperature: $('#template-monitor-temperature').html()
    };
    $.each(templates, function (index, value) {
        Mustache.parse(value);
    });

    var monitor = {
        fetch: function (id, onSuccess, onComplete) {
            $.ajax({
                url: '/monitor/ajax-get',
                data: {
                    id: id
                },
                success: function (json) {
                    if (json.ok) {
                        onSuccess(json.monitor);
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
        render: function (item) {
            item.data = JSON.parse(item.data);
            var template = templates[item.data.type];
            return Mustache.render(template, item);
        }
    };

    var $id = $('input#id');
    monitor.fetch($id.val(), function (item) {
        var result = monitor.render(item);
        $app.html(result);
        $(".input-knob").knob();
    }, function () {
        console.log('loaded.');
    });
});
