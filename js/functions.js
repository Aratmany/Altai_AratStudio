(function ($) {
    "use strict";

    if (!$.tempusThemeExtensions)
        $.tempusThemeExtensions = {};
    
    function tempusThemeCore() {
        var self = this;
   
    };


    
    
    $.fn.wrapStart = function(numWords){
        return this.each(function(){
            var $this = $(this);
            var node = $this.contents().filter(function(){
                return this.nodeType == 3;
            }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
            if (!node.length) return;
            node[0].nodeValue = text.slice(first.length);
            node.before('<b>' + first + '</b>');
        });
    };

    $(document).ready(function() {


     

        $('.mod-heading .widget-title > span').wrapStart(1);

    });

    jQuery(window).on("elem/frontend/init", function() {
        
   

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_brands.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_features_box.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_instagram.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_posts.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_testimonials.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        // inisiats elements
        elemFrontend.hooks.addAction( "frontend/element_ready/temp_inisiat_board_inisiats.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_inisiat_board_inisiats_tabs.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_inisiat_board_inisiat_lom.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elemFrontend.hooks.addAction( "frontend/element_ready/temp_inisiat_board_lom.default",
            function($scope) {
                tempusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

    });
})(jQuery);

