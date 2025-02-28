(function ($) {
    "use strict";
// When the window has finished loading create our google map below
    $.fn.iwMap = function () {
        $(this).each(function () {
            if ($(this).hasClass('map-rendered')) {
                return;
            }
            var mapObj = this;
            $(this).addClass('map-rendered');
            this.mapOptions = {
				//zoomControl: false,
				//scaleControl: false,
				//panControl: false,
				scrollwheel: false,
				//disableDoubleClickZoom: true,  
				//draggable: false,
                // How zoomed in you want the map to start at (always required)
                zoom: $(this).data('zoom'),
                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng($(this).data('lat'), $(this).data('long')),
                // How you would like to style the map. 
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{"featureType": "landscape", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "transit", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "road", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"stylers": [{"hue": "#00aaff"}, {"saturation": -100}, {"gamma": 2.15}, {"lightness": 12}]}, {"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"visibility": "on"}, {"lightness": 24}]}, {"featureType": "road", "elementType": "geometry", "stylers": [{"lightness": 57}]}]
            };
            this.gmap = new google.maps.Map($(this).find('.map-view').get(0), this.mapOptions);
            if ($(this).data('image') !== '') {
                this.marker = new google.maps.Marker({
                    position: new google.maps.LatLng($(this).data('lat'), $(this).data('long')),
                    map: this.gmap,
                    title: $(this).data('title'),
                    icon: $(this).data('image')
                });
                this.markerinfowindow = new google.maps.InfoWindow();
                if ($(this).data('info') !== '') {
                    this.markerinfowindow.setContent('<div class="content-info">' + $(this).data('info') + '<div>');
                    this.markerinfowindow.open(this.gmap, this.marker);
                    google.maps.event.addListener(this.marker, 'click', function () {
                        mapObj.markerinfowindow.setContent('<div class="content-info">' + $(mapObj).data('info') + '<div>');
                        mapObj.markerinfowindow.open(mapObj.gmap, mapObj.marker);
                    });
                }
            }
        });
    };
})(jQuery);