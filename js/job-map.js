(function($) {
    "use strict";
    
    var map, mapSidebar, markers, CustomHtmlIcon, group;
    var markerArray = [];

    $.extend($.tempusThemeCore, {
        /**
         *  Initialize scripts
         */
        inisiat_map_init: function() {
            var self = this;

            if ($('#inisiats-google-maps').length) {
                L.Icon.Default.imagePath = 'wp-content/themes/temp/images/';
            }
            
            setTimeout(function(){
                self.mapInit();
            }, 50);
            
        },
        
        mapInit: function() {
            var self = this;

            var $window = $(window);

            if (!$('#inisiats-google-maps').length) {
                return;
            }

            map = L.map('inisiats-google-maps', {
                scrollWheelZoom: false
            });

            markers = new L.MarkerClusterGroup({
                showCoverageOnHover: false
            });

            CustomHtmlIcon = L.HtmlIcon.extend({
                options: {
                    html: "<div class='map-popup'></div>",
                    iconSize: [30, 30],
                    iconAnchor: [22, 30],
                    popupAnchor: [0, -30]
                }
            });

            $window.on('pxg:refreshmap', function() {
                map._onResize();
                setTimeout(function() {
                    if(markerArray.length > 0 ){
                        group = L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds()); 
                    }
                }, 100);
            });

            $window.on('pxg:simplerefreshmap', function() {
                map._onResize();
            });

            $(window).resize(function(){
                map._onResize();
                setTimeout(function() {
                    if(markerArray.length > 0 ){
                        group = L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds()); 
                    }
                }, 100);
            });
            
            if ( temp_inisiat_map_opts.mapbox_token != '' ) {
                var tileLayer = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a> <strong><a href='https://www.mapbox.com/map-feedback/' target='_blank'>Improve this map</a></strong>",
                    maxZoom: 18,
                    //detectRetina: true,
                    id: temp_inisiat_map_opts.mapbox_style,
                    accessToken: temp_inisiat_map_opts.mapbox_token
                });
            } else {
                if ( temp_inisiat_map_opts.custom_style != '' ) {
                    try {
                        var custom_style = $.parseJSON(temp_inisiat_map_opts.custom_style);
                        var tileLayer = L.gridLayer.googleMutant({
                            type: 'roadmap',
                            styles: custom_style
                        });

                    } catch(err) {
                        var tileLayer = L.gridLayer.googleMutant({
                            type: 'roadmap'
                        });
                    }
                } else {
                    var tileLayer = L.gridLayer.googleMutant({
                        type: 'roadmap'
                    });
                }
                $('#tempus-listing-map').addClass('map--google');
            }

            map.addLayer(tileLayer);

            // check archive/single page
            if ( !$('#inisiats-google-maps').is('.single-inisiat-map') ) {
                self.updateMakerCards();
            } else {
                var $item = $('.single-listing-wrapper');
                
                if ( $item.data('latitude') !== "" && $item.data('latitude') !== "" ) {
                    var zoom = (typeof MapWidgetZoom !== "undefined") ? MapWidgetZoom : 15;
                    self.addMakerToMap($item);
                    map.addLayer(markers);
                    //map.setActiveArea('active-area');
                    map.setView([$item.data('latitude'), $item.data('longitude')], zoom);
                    $(window).on('update:map', function() {
                        map.setView([$item.data('latitude'), $item.data('longitude')], zoom);
                    });
                } else {
                    $('#inisiats-google-maps').hide();
                }
            }
        },
        updateMakerCards: function() {
            var self = this;
            var $items = $('.inisiats-listing-wrapper .inisiat_listing');
            
            if ($('#inisiats-google-maps').length && typeof map !== "undefined") {

                if (!$items.length) {
                    map.setView([temp_inisiat_map_opts.default_latitude, temp_inisiat_map_opts.default_longitude], 12);
                    return;
                }
                
                map.removeLayer(markers);
                markers = new L.MarkerClusterGroup({
                    showCoverageOnHover: false
                });
                $items.each(function(i, obj) {
                    self.addMakerToMap($(obj), true);
                });
                // map.fitBounds(markers, {
                //     padding: [50, 50]
                // });

                map.addLayer(markers);

                if(markerArray.length > 0 ){
                    group = L.featureGroup(markerArray);
                    map.fitBounds(group.getBounds()); 
                }
            }
        },
        addMakerToMap: function($item, archive) {
            var self = this;
            var marker;

            if ( $item.data('latitude') == "" || $item.data('longitude') == "") {
                return;
            }

            var mapPinHTML = "<div class='map-popup'><div class='icon-wrapper'></div></div>";

            marker = L.marker([$item.data('latitude'), $item.data('longitude')], {
                icon: new CustomHtmlIcon({ html: mapPinHTML })
            });

            if (typeof archive !== "undefined") {

                $item.on('mouseenter', function() {
                    $(marker._icon).find('.map-popup').addClass('map-popup-selected');
                }).on('mouseleave', function(){
                    $(marker._icon).find('.map-popup').removeClass('map-popup-selected');
                });

                var logo_html = '';
                if ( $item.find('.lom-logo img').length ) {
                    logo_html =  "<div class='image-wrapper image-loaded'>" +
                                "<img src='" + $item.find('.lom-logo img').attr('src') + "' alt=''>" +
                            "</div>";
                }

                var title_html = '';
                if ( $item.find('.inisiat-title').length ) {
                    title_html = "<div class='inisiat-title'>" + $item.find('.inisiat-title').html() + "</div>";
                }
                var meta_html = '';
                if ( $item.find('.inisiat-metas').length ) {
                    meta_html = "<div class='inisiat-metas'>" + $item.find('.inisiat-metas').html() + "</div>";
                }

                marker.bindPopup(
                    "<div class='inisiat-grid-style'>" +
                        "<div class='listing-image'>" + logo_html +
                            "<div class='listing-title-wrapper'>" + title_html + meta_html + "</div>" +
                        "</div>" + 
                    "</div>").openPopup();
            }

            markers.addLayer(marker);
            markerArray.push(L.marker([$item.data('latitude'), $item.data('longitude')]));
        },
        
    });

    $.tempusThemeExtensions.inisiat_map = $.tempusThemeCore.inisiat_map_init;

    
})(jQuery);
