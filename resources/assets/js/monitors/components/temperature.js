
define(['jquery', 'moment', 'Chartist', 'monitors/monitor', 'monitors/timeout'],
    function ($, moment, Chartist, model, TIMEOUT) {

    var id = $('input#id').val();
    var $app = $('div#monitor-view');

    var utils = {
        moment: function () {
            return function (text, render) {
                return moment(render(text)).fromNow();
            };
        }
    };

    var Temperature = function (template, monitor) {
        this.template = template;
        this.monitor = $.extend(monitor, utils);
        this.chartOptions = {
            low: this.monitor.data.min,
            high: this.monitor.data.max,
            lineSmooth: Chartist.Interpolation.simple({
                divisor: 2
            })
        };
    };

    Temperature.prototype.render = function (items) {
        items = items || [];
        var len = items.length;
        this.monitor.item = items[len - 1];
        var result = model.render(this.template, this.monitor);
        $app.html(result);
        $(".input-knob").knob({
            readOnly: true,
            width: 250,
            fontWeight: 'hack', // hack: override default font size!
            fgColor: '#3498db'
        });
    };
    Temperature.prototype.plot = function (items) {
        items = items || [];
        var labels = [];
        var serie = [];
        var len = items.length;
        for (var i = 0; i < len; i++) {
            var item = items[i];
            labels.push(item.created_at);
            serie.push(item.data.value);
        }

        this.chart = new Chartist.Line('.ct-chart', {
            labels: labels,
            series: [serie]
        }, this.chartOptions);
    };

    $.when(
        $.get('/mustache/monitor/temperature.mustache'),
        model.fetch(id, onCompleteOnce),
        model.measures(id, onCompleteOnce)
    ).done(function (resp1, resp2, resp3) {
        var template = resp1[0];
        var monitor = resp2[0].monitor;
        var items = resp3[0].items;
        var t = new Temperature(template, monitor);
        t.render(items);
        t.plot(items);
        onComplete(t);
    });

    function onCompleteOnce() {
        console.info('promise loaded.');
    }

    function onComplete(temperature) {
        setTimeout(function () {
            var promise = model.measures(id);
            promise.done(function (resp) {
                var items = resp.items;
                temperature.render(items);
                temperature.plot(items);
                onComplete(temperature);
            });
        }, TIMEOUT);
    }
});
