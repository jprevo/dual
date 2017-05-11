$(function() {

    'use strict';

    $('.js-select').on('click', function(e) {
        e.preventDefault();

        var selector = new Selector($(this));
    });

});