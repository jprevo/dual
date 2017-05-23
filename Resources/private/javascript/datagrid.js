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