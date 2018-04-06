function initMap() {
    window.map = new App();
    window.map.init();
}

var App = function() {
    var map, wrapper, autocomplete;
}

App.prototype = {
    init: function() {
        this.wrapper = document.getElement('.map-wrapper');


        if (this.wrapper) {
            this.map = new google.maps.Map(this.wrapper.getElement('#map'), {
                center: {lat: 51.2495952, lng: 10.8674153},
                zoom: 6
            });

            this.setAutocomplete();
        }


    },

    setAutocomplete: function() {
        var self = this;

        this.autocomplete = new google.maps.places.Autocomplete(this.wrapper.getElement('#search'));
        this.autocomplete.bindTo('bounds', this.map);

        this.autocomplete.addListener('place_changed', function() {
            var place = self.autocomplete.getPlace();

            if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                self.map.fitBounds(place.geometry.viewport);
            } else {
                self.map.setCenter(place.geometry.location);
                self.map.setZoom(17);  // Why 17? Because it looks good.
            }
        });
    },

    setEvents: function() {
        var self = this;

        this.wrapper.addEvents({
            'keyup:relay(#search)' : function(e, target) {
                if (e.code == 13) {
                    self.search(target.get('value'));
                }
            }
        });
    },

    search : function(place) {
        console.log(place);
    }
}
