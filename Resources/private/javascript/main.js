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