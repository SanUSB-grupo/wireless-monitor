
define(['jquery', 'moment', 'Chart', 'monitors/timeout', 'monitors/monitor'],
    function ($, moment, Chart, TIMEOUT, model) {

    var id = $('input#id').val();
    var $app = $('div#monitor-view');
    var LIMIT = 30;
    var ORDER = 'desc';

    Chart.defaults.global.animation = 0;

    function notHigherNotLower(value, min, max) {
        if (value < min) {
            return min;
        } else if (value > max) {
            return max;
        }
        return value;
    }

    /**
     * safe convert to integer
     * @param {any} x
     */
    function ToInteger(x) {
        x = Number(x);
        return x < 0 ? Math.ceil(x) : Math.floor(x);
    }

    var utils = {
        moment: function () {
            return function (text, render) {
                return moment(render(text)).fromNow();
            };
        },
        getFgColor: function () {
            var min = ToInteger(this.data.min);
            var max = ToInteger(this.data.max);
            var total = max - min;
            var third = total / 3.0;
            var value = ToInteger(this.item.data.value);
            var color = '#3498db'; // blue
            if (value >= min && value < (min + third)) {
                color = '#f39c12'; // yellow
            } else if (value > (max - third) && value <= max) {
                color = '#e74c3c'; // red
            }
            return function (text, render) {
                return color;
            }
        },
        getValue: function () {
            var value = notHigherNotLower(
                this.item.data.value, this.data.min, this.data.max);
            return function (text, render) {
                return value;
            }
        }
    };

    var Temperature = function (template, monitor) {
        this.template = template;
        this.monitor = $.extend(monitor, utils);
        this.chartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        min: this.monitor.data.min * 1,
                        max: this.monitor.data.max * 1
                    }
                }],
                paddingRight: 10,
            }
        };
    };

    Temperature.prototype.render = function (items) {
        items = items || [];
        var len = items.length;
        if (len > 0) {
            this.monitor.item = items[0];
            var result = model.render(this.template, this.monitor);
            $app.html(result);
            $(".input-knob").knob({
                readOnly: true,
                width: 250,
                fontWeight: 'hack', // hack: override default font size!
            });
        }
    };

    Temperature.prototype.plot = function (items) {
        items = items || [];
        var labels = [];
        var serie = [];
        var len = items.length;
        if (len > 0) {
            for (var i = len - 1; i >= 0; i--) {
                var item = items[i];
                labels.push(item.created_at);
                var value = notHigherNotLower(
                    item.data.value, this.monitor.data.min, this.monitor.data.max);
                serie.push(value);
            }

            var $ctx = $('#temperature-chart');
            var ctx = $ctx.get(0).getContext('2d');

            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: this.monitor.data.description,
                        data: serie,
                        borderColor: 'rgba(52,152,219,1)',
                        pointBackgroundColor: 'rgba(52,152,219,1)',
                        pointBorderColor: 'rgba(52,152,219,1)',
                        pointHoverBackgroundColor: '#fff',
                        pointBorderWidth: 4,
                        backgroundColor: 'rgba(151,187,205,0.2)',
                    }]
                },
                options: this.chartOptions
            });
        }
    };

    $.when(
        $.get('/templates/temperature/show.mustache'),
        model.fetch(id, onCompleteOnce),
        model.measures(id, LIMIT, ORDER, onCompleteOnce)
    ).done(function (resp1, resp2, resp3) {
        var template = resp1[0];
        var monitor = resp2[0].monitor;
        var items = resp3[0].items;

        var t = new Temperature(template, monitor);
        t.render(items);
        t.plot(items);
        // if there's no data, send user to setup tab
        if (!items.length) {
            $app.html('');
            $('.nav-tabs a#tab-setup').tab('show');
        }
        onComplete(t);
    });

    function onCompleteOnce() {
        console.info('Promise loaded.');
    }

    function onComplete(temperature) {
        setTimeout(function () {
            var promise = model.measures(id, LIMIT, ORDER);
            promise.done(function (resp) {
                var items = resp.items;
                temperature.render(items);
                temperature.plot(items);
                onComplete(temperature);
            });
        }, TIMEOUT);
    }
});
