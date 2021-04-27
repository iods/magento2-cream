define(['jquery'], function ($) {
    return function(config, domElement) {
        $(domElement).css({backgroundColor: config.color});
    }
});
