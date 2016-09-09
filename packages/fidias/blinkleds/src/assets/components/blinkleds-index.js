
$(function () {
    var template = $('#template-led').html();
    Mustache.parse(template, tags = ['#{', '}']);
    var $list = $('#led-list');

    var $button = $('#new-led');
    $button.click(function () {
        var len = $list.find('.led--item').length;
        render({id: len});
    });

    function render(element) {
        var result = Mustache.render(template, element);
        $list.append(result);
    }

    // if the list is empty, render the first one!
    if (!$list.html().trim()) {
        render({id: 0});
    }

    $('.delete-last-one').click(function () {
        $list.find('.led--item:last').remove();
    });
});
