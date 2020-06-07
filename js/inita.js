(function($) {
    "use strict";
    
    var ajax_filter_request;

    $.extend($.tempusThemeCore, {
  
        inisiat_init: function() {
            var self = this;

            if ( self.message_form_html == null && $('.send-private-message-wrapper-hidden').length > 0 ) {
                self.message_form_html = $('.send-private-message-wrapper-hidden').html();
                $('.send-private-message-wrapper-hidden').html('');
            }

            self.select2Init();

            self.sendPrivateMessage();

            self.listingDetail();

            self.filterListingFnc();

            self.userRegister();

            self.listingBtnFilter();

            setTimeout(function(){
                self.changePaddingTopContent();
            }, 100);
            
            $(window).resize(function(){
                setTimeout(function(){
                    self.changePaddingTopContent();
                }, 100);
            });

            self.showContentSidebarListing();

            $(document).on('change', 'form.filter-listing-form input, form.filter-listing-form select', function (e) {
                var form = $(this).closest('form.filter-listing-form');
                if ( $(this).attr('name') == 'filter-sala-type' ) {
                    form.find('input[name=filter-sala-from]').val('');
                    form.find('input[name=filter-sala-to]').val('');
                }
                setTimeout(function(){
                    form.trigger('submit');
                }, 200);
            });

            $(document).on('submit', 'form.filter-listing-form', function (e) {
                e.preventDefault();
                var url = $(this).attr('action') + '?' + $(this).serialize();
                self.inisiatsGetPage( url );
                return false;
            });


            $(document).on('change', 'form.inisiats-ordering select.orderby', function(e) {
                e.preventDefault();
                $('form.inisiats-ordering').trigger('submit');
            });
            
            $(document).on('submit', 'form.inisiats-ordering', function (e) {
                var url = $(this).attr('action') + '?' + $(this).serialize();
                self.inisiatsGetPage( url );
                return false;
            });
 
            if ( $('.ajax-pagination').length ) {
                self.ajaxPaginationLoad();
            }

        },
        select2Init: function() {
            // select2
            if ( $.isFunction( $.fn.select2 ) && typeof wp_inisiat_board_select2_opts !== 'undefined' ) {
                var select2_args = wp_inisiat_board_select2_opts;
                select2_args['allowClear']              = true;
                select2_args['minimumResultsForSearch'] = 10;
                
                $( 'select[name=filter-location]' ).select2( select2_args );
                $( 'select[name=filter-type]' ).select2( select2_args );
                $( 'select[name=filter-category]' ).select2( select2_args );
            }
        },
        changePaddingTopContent: function() {
            if ($(window).width() >= 1200) {
                var header_h = $('#tempus-header').outerHeight();
            } else {
                var header_h = $('#tempus-header-sanar').outerHeight();
            }
            if ($('#inisiats-google-maps').is('.fix-map')) {
                $('#inisiats-google-maps').css({ 'top': header_h, 'height': 'calc(100vh - ' + header_h+ 'px)' });
                $('#tempus-main-content').css({ 'padding-top': header_h });
            }
            
            $('.layout-type-half-map .filter-sidebar').css({ 'padding-top': header_h + 20 });
            $('.layout-type-half-map .filter-scroll').perfectScrollbar();
      
            $('.offcanvas-filter-sidebar').css({ 'padding-top': header_h + 10 });
        },
        listingChangeMarginTopAffix: function() {
            var affix_height = 0;
                if ( $('.panel-affix').length > 0 ) {
                    affix_height = $('.panel-affix').outerHeight();
                    $('.panel-affix-wrapper').css({'height': affix_height});
                }
            return affix_height;
        },
        sendPrivateMessage: function() {
            var self = this;
            $(document).on('click', '.send-private-message-btn', function() {
                $.magnificPopup.open({
                    mainClass: 'wp-inisiat-board-mfp-container popup-private-message',
                    items    : {
                        src : self.message_form_html,
                        type: 'inline'
                    }
                });
            });
        },
        listingDetail: function() {
            var self = this;
     

  
            var affix_height = 0;
            var affix_height_top = 0;
            setTimeout(function(){
                affix_height = affix_height_top = self.listingChangeMarginTopAffix();
            }, 50);
            $(window).resize(function(){
                affix_height = affix_height_top = self.listingChangeMarginTopAffix();
            });

          
            setTimeout(function(){
              
                var stickyElement   = '.panel-affix',  
                    bottomElement   = '#tempus-footer';

              
                if($( stickyElement ).length){
                    $( stickyElement ).each(function(){
                        var header_height = 0;
                        if ($(window).width() >= 1200) {
                            if ($('.main-sticky-header').length > 0) {
                                header_height = $('.main-sticky-header').outerHeight();
                                affix_height_top = affix_height + header_height;
                            }
                        } else {
                            header_height = $('#tempus-header-sanar').outerHeight();
                            affix_height_top = affix_height + header_height;
                            header_height = 0;
                        }
                        affix_height_top = affix_height_top + 10;
              
                        var fromTop = $( this ).offset().top,
                            fromBottom = $( document ).height()-($( this ).offset().top + $( this ).outerHeight()),
                       
                            stopOn = $( document ).height()-( $( bottomElement ).offset().top)+($( this ).outerHeight() - $( this ).height()); 
            
                        
                        if( (fromBottom-stopOn) > 200 ){
                          
                            $( this ).css('width', $( this ).width()).css('top', 0).css('position', '');
                        
                            $( this ).affix({
                                offset: { 
                                   
                                    top: fromTop - header_height,  
                                   
                                }
                           
                            }).on('affix.bs.affix', function(){
                                var header_height = 0;
                                if ($(window).width() >= 1200) {
                                    if ($('.main-sticky-header').length > 0) {
                                        header_height = $('.main-sticky-header').outerHeight();
                                        affix_height_top = affix_height + header_height;
                                    }
                                } else {
                                    header_height = $('#tempus-header-sanar').outerHeight();
                                    affix_height_top = affix_height + header_height;
                                }
                                affix_height_top = affix_height_top + 10;
                                $( this ).css('top', header_height).css('position', header_height);
                            });
                        }
                      
                        $( window ).trigger('scroll'); 
                    }); 
                }

    
                $('body').scrollspy({
                    target: ".header-tabs-nav",
                    offset: affix_height_top + 20
                });
            }, 50);
    
    
            $('.panel-affix a[href*=#]:not([href=#])').on('click', function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                  if (target.length) {
                    $('html,body').animate({
                      scrollTop: target.offset().top - affix_height_top
                    }, 1000);
                    return false;
                  }
                }
            });

            $(document).on('click', '.add-a-review', function(e) {
                e.preventDefault();
                var $id = $(this).attr('href');
                if ( $($id).length > 0 ) {
                    $('html,body').animate({
                      scrollTop: $($id).offset().top - 100
                    }, 1000);
                }
            });
        },
        listingBtnFilter: function(){
            $('.btn-view-map').on('click', function(e){
                e.preventDefault();
                $('#inisiats-google-maps').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.content-listing .inisiats-listing-wrapper').addClass('hidden-sm').addClass('hidden-xs');
                $('.btn-view-listing').removeClass('hidden-sm').removeClass('hidden-xs');
                $(this).addClass('hidden-sm').addClass('hidden-xs');
                $('.inisiats-pagination-wrapper').addClass('p-fix-pagination');
                setTimeout(function() {
                    $(window).trigger('pxg:refreshmap');
                });
            });
            $('.btn-view-listing').on('click', function(e){
                e.preventDefault();
                $('#inisiats-google-maps').addClass('hidden-sm').addClass('hidden-xs');
                $('.content-listing .inisiats-listing-wrapper').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.btn-view-map').removeClass('hidden-sm').removeClass('hidden-xs');
                $(this).addClass('hidden-sm').addClass('hidden-xs');
                $('.inisiats-pagination-wrapper').removeClass('p-fix-pagination');
            });

            $('.show-filter-inisiats, .filter-in-sidebar').on('click', function(e){
                e.stopPropagation();
                $('.layout-type-half-map .filter-sidebar').toggleClass('active');
                $('.filter-sidebar + .over-dark').toggleClass('active');
            });
            $(document).on('click', '.filter-sidebar + .over-dark', function(){
                $('.layout-type-half-map .filter-sidebar').removeClass('active');
                $('.filter-sidebar + .over-dark').removeClass('active');
            });
        },

        

        userRegister: function(){
            $('body').on('click', '.role-tabs > li', function(){
                $('.role-tabs > li').removeClass('active');
                $(this).addClass('active');
            });
        },


        showContentSidebarListing: function(){
            $('form .toggle-field.hide-content .heading-label i').removeClass('fa-angle-down').addClass('fa-angle-up');
            $('body').on('click', 'form .toggle-field .heading-label', function(){
                $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            });
        },
        inisiatsGetPage: function(pageUrl, isBackButton){
            var self = this;

            if ( self.filterAjax ) {
                self.filterAjax.abort();
            }
            
            self.inisiatsSetCurrentUrl();

            if (pageUrl) {
            
                self.inisiatsShowLoader();
                

                pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
                
                if (!isBackButton) {
                    self.setPushState(pageUrl);
                }

                self.filterAjax = $.ajax({
                    url: pageUrl,
                    data: {
                        load_type: 'full'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    
                    method: 'POST',
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('tempus: AJAX error - inisiatsGetPage() - ' + errorThrown);
                        
                     
                        self.inisiatsHideLoader();
                        
                        self.filterAjax = false;
                    },
                    success: function(response) {
                 
                        self.inisiatsUpdateContent(response);
                        
                        self.filterAjax = false;
                    }
                });
                
            }
        },
        inisiatsHideLoader: function(){
            $('body').find('.main-items-wrapper').removeClass('loading');
        },
        inisiatsShowLoader: function(){
            $('body').find('.main-items-wrapper').addClass('loading');
        },
        setPushState: function(pageUrl) {
            window.history.pushState({tempusShop: true}, '', pageUrl);
        },
        inisiatsSetCurrentUrl: function() {
            var self = this;
            

            self.searchAndTagsResetURL = window.location.href;
        },
    

        ajaxPaginationLoad: function() {
            var self = this,
                $infloadControls = $('body').find('.ajax-pagination'),                   
                nextPageUrl;

            self.infloadScroll = ($infloadControls.hasClass('infinite-action')) ? true : false;
            
            if (self.infloadScroll) {
                self.infscrollLock = false;
                
                var pxFromWindowBottomToBottom,
                    pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);

                
               
                var to = null;
                $(window).resize(function() {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function() {
                        var $infloadControls = $('.ajax-pagination'); // Note: Don't cache, element is dynamic
                        pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    }, 100);
                });
                
                $(window).scroll(function(){
                    if (self.infscrollLock) {
                        return;
                    }
                    
                    pxFromWindowBottomToBottom = 0 + $(document).height() - ($(window).scrollTop()) - $(window).height();
                    
        
                    if (pxFromWindowBottomToBottom < pxFromMenuToBottom) {
                        self.ajaxPaginationGet();
                    }
                });
            } else {
                var $productsWrap = $('body');
        
                $productsWrap.on('click', '.main-pagination-wrapper .tempus-loadmore-btn', function(e) {
                    e.preventDefault();
                    self.ajaxPaginationGet();
                });
                
            }
            
            if (self.infloadScroll) {
                $(window).trigger('scroll'); 
            }
        },
    
        ajaxPaginationGet: function() {
            var self = this;
            
            if (self.filterAjax) return false;
            

            var $nextPageLink = $('.tempus-pagination-next-link').find('a'),
                $infloadControls = $('.ajax-pagination'),
                nextPageUrl = $nextPageLink.attr('href');
            
            if (nextPageUrl) {
        
                $infloadControls.addClass('tempus-loader');
                
                self.setPushState(nextPageUrl);

                self.filterAjax = $.ajax({
                    url: nextPageUrl,
                    data: {
                        load_type: 'items'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'GET',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('tempus: AJAX error - ajaxPaginationGet() - ' + errorThrown);
                    },
                    complete: function() {
          
                        $infloadControls.removeClass('tempus-loader');
                    },
                    success: function(response) {
                        var $response = $('<div>' + response + '</div>'), 
                            $gridItemElement = $('.items-wrapper', $response).html(),
                            $resultCount = $('.results-count .last', $response).html(),
                            $display_mode = $('.main-items-wrapper').data('display_mode');
                        

              
                        if ( $display_mode == 'grid' || $display_mode == 'simple') {
                            $('.main-items-wrapper .items-wrapper .row').append($gridItemElement);
                        } else {
                            $('.main-items-wrapper .items-wrapper').append($gridItemElement);
                        }
           
         
                        $('.main-items-wrapper .results-count .last').html($resultCount);

                    
                        self.updateMakerCards(response);

             
                        self.layzyLoadImage();
                        
               
                        nextPageUrl = $response.find('.tempus-pagination-next-link').children('a').attr('href');
                        
                        if (nextPageUrl) {
                            $nextPageLink.attr('href', nextPageUrl);
                        } else {
                            $('.main-items-wrapper').addClass('all-inisiats-loaded');
                            
                            if (self.infloadScroll) {
                                self.infscrollLock = true;
                            }
                            $infloadControls.find('.tempus-loadmore-btn').addClass('hidden');
                            $nextPageLink.removeAttr('href');
                        }
                        
                        self.filterAjax = false;
                        
                        if (self.infloadScroll) {
                            $(window).trigger('scroll'); 
                        }
                    }
                });
            } else {
                if (self.infloadScroll) {
                    self.infscrollLock = true; 
                }
            }
        },
     
    });

    $.tempusThemeExtensions.inisiat = $.tempusThemeCore.inisiat_init;

    
})(jQuery);
