(function ($, require) {
    $(document).ready(function () {
        var ajaxHelper = require('ajaxHelper');
        var UI = require('piwik/UI');
        var notification = new UI.Notification();
        $("body").on("click", "a.quickExcludeButton", function () {
            var ip = $(this).data("ip");
            var ajax = new ajaxHelper();
            ajax.addParams({
                module: 'QuickExcludeVisitorIP',
                action: 'ignoreIP',
                ip: ip
            }, 'post');
            ajax.setCallback(function (response) {
                notification.show(response.message, response.options);
            });
            ajax.setFormat('json');
            ajax.send(false);
        });
    });
})(jQuery, require);