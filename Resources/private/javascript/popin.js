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