var Datagrid = function($container) {
    var t = this;

    var init = function() {
        $container.on('click', '.js-datagrid-link', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            t.reload(url);
        });
    };

    t.reload = function(url) {
        $container.css('opacity', 0.3);

        $.get(url, function(response) {
            $container.html(response);
            $container.css('opacity', 1);
        });
    };

    init();
};
$(function() {

    'use strict';

    $('.js-select').on('click', function(e) {
        e.preventDefault();
        var selector = new Selector($(this));
    });

    $('.datagrid').each(function() {
        var datagrid = new Datagrid($(this));
    });
});
var Popin = function(content) {
    'use strict';

    var t = this;

    t.content = content;
    var $popin;

    t.open = function() {
        $popin = $('<div class="popin-lg"></div>');
        $popin.html(t.content);
        $('body').append($popin);
    };

    t.close = function() {
        $('body > .popin-lg').remove();
    };

    t.find = function(selector) {
        return $popin.find(selector);
    };

};
var Selector = function($link) {
    'use strict';

    var t = this;
    t.multiple = false;
    t.em = null;
    t.class = null;
    t.datagrid = null;
    t.data = [];

    var init = function() {
        t.multiple = $link.data('multiple');
        t.em = $link.data('em');
        t.class = $link.data('class');

        t.open();
    };

    t.open = function() {
        $.get(window.dual.selectUrl, {
            'em': t.em,
            'cl': t.class,
            'multiple': t.multiple
        }, function(response) {
            var popin = new Popin(response);
            popin.open();
            t.initPopin(popin);
        });
    };

    t.initPopin = function(popin) {
        t.datagrid = new Datagrid(popin.find('.datagrid'));

        popin.find('.select-form').on('submit', function(e) {
            e.preventDefault();
            t.data = t.getFormData($(this));

            var $container = $link.parents('.js-association');
            $container.find('.js-selected').text(JSON.stringify(t.data));
            $container.find('[type=hidden]').val(JSON.stringify(t.data));

            popin.close();
        });
    };

    t.getFormData = function($form) {
        var data = [];
        var selector = '[type=checkbox]:checked';

        $form.find(selector).each(function() {
            data.push($(this).val());
        });

        if (!t.multiple) {
            data = data.shift();
        }

        return data;
    };

    init();
};