var Popin = function(content) {
    'use strict';

    var t = this;

    t.content = content;

    t.open = function() {
        var $popin = $('<div class="popin-lg"></div>');
        $popin.html(t.content);
        $('body').append($popin);
    };

    t.close = function() {
        $('body > .popin-lg').remove();
    };
};