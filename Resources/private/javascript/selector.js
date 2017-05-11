var Selector = function($link) {
    'use strict';

    var t = this;
    t.multiple = false;
    t.em = null;
    t.class = null;

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
        });
    };

    init();
};