define(['jquery', 'moment', 'monitors/timeout', 'monitors/monitor'],
    function ($, moment, TIMEOUT, model) {

    var id = $('input#id').val();
    var $app = $('div#monitor-view');
    var LIMIT = 10;
    var ORDER = 'desc';

    var utils = {
        moment: function () {
            return function (text, render) {
                return moment(render(text)).fromNow();
            };
        }
    };

    var Blinkleds = function (template, monitor) {
        this.template = template;
        this.monitor = $.extend(monitor, utils);
        this.timeline = [];
        this.monitor.currentTimelineItem = null;
        this.monitor.LIMIT = LIMIT;
    }

    Blinkleds.prototype.getLeds = function () {
        var clone = $.extend(true, {}, this.monitor.data);
        return clone.leds;
    };

    Blinkleds.prototype.setCurrentLeds = function (leds) {
        this.monitor.currentLeds = leds;
    }

    Blinkleds.prototype.load = function (items) {
        items = items || [];
        var itemsLength = items.length;

        if (itemsLength > 0) {
            // update date
            this.monitor.created_at = items[0].created_at;

            var item = items[0];
            var currentLeds = this.renderItem(item);
            this.setCurrentLeds(currentLeds);
        }
    }

    Blinkleds.prototype.render = function () {
        var result = model.render(this.template, this.monitor);
        $app.html(result);
    }

    Blinkleds.prototype.renderItem = function (item) {
        var monitorLeds = this.getLeds();
        var leds = item.data.leds;
        for (var j = 0; j < leds.length; j++) {
            for (var k = 0; k < monitorLeds.length; k++) {
                if (leds[j].id === monitorLeds[k].id) {
                    monitorLeds[k].on = (leds[j].status === 'on') ? true : false;
                }
            }
        }
        return monitorLeds;
    };

    Blinkleds.prototype.setTimeline = function (items) {
        this.monitor.timeline = items;
    };

    Blinkleds.prototype.renderTimelineItem = function (id) {
        var item = undefined;
        if (id) {
            var len = this.monitor.timeline.length;
            for (var i = 0; i < len; i++) {
                item = this.monitor.timeline[i];
                if (item.id == id) {
                    break;
                }
            }
            item.leds = this.renderItem(item);
        }
        this.monitor.currentTimelineItem = item;
    };

    $.when(
        $.get('/templates/blinkleds/show.mustache'),
        model.fetch(id, onCompleteOnce),
        model.measures(id, LIMIT, ORDER, onCompleteOnce)
    ).done(function (resp1, resp2, resp3) {
        var template = resp1[0];
        var monitor = resp2[0].monitor;
        var items = resp3[0].items;
        var obj = new Blinkleds(template, monitor);
        obj.load(items);
        obj.setTimeline(items);
        obj.render();
        // if there's no data, send user to setup tab
        if (!items.length) {
            $app.html('');
            $('.nav-tabs a#tab-setup').tab('show');
        }
        onComplete(obj);

        $(document).on('click', '.bottom-element a', function () {
            var id = $(this).data('id');
            obj.renderTimelineItem(id);
            obj.render();
            return false;
        }).on('click', 'button.btn-close', function () {
            obj.renderTimelineItem();
            obj.render();
            return false;
        });
    });

    function onCompleteOnce() {
        console.info('promise loaded.');
    }

    function onComplete(object) {
        setTimeout(function () {
            var promise = model.measures(id, LIMIT, ORDER);
            promise.done(function (resp) {
                var items = resp.items;
                object.load(items);
                object.setTimeline(items);
                object.render();
                onComplete(object);
            });
        }, TIMEOUT);
    }
});
