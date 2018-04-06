function initMap() {
    window.map = new App();
    window.map.init();
}

var App = function() {
}

App.prototype = {
    init: function() {
        var self = this;

        this.places  = {};
        this.markers = [];

        this.wrapper   = document.getElement('.map-wrapper');
        this.placeList = document.getElement('#places');

        if (this.wrapper) {
            this.map = new google.maps.Map(this.wrapper.getElement('#map'), {
                center: {lat: 51.2495952, lng: 10.8674153},
                zoom: 6
            });

            this.setAutocomplete();
            this.getPlaces();


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

            self.addPlace(place);

            self.savePlaces();
        });
    },

    getPlaces: function() {
        var self = this;
        new Request.JSON({
            url: 'api.php',
            data: {
                'method': 'getAll'
            },
            onSuccess: function(response) {
                if (response.status && response.status == 'ok') {
                    response.data.each(function(place) {
                        self.getPlaceFromId(place.place_id);
                    });
                }
            }
        }).send();
    },

    savePlaces: function() {
        new Request.JSON({
            url: 'api.php',
            data: {
                'method': 'setPlaces',
                'places': this.places
            },
            onSuccess: function(response) {
                console.log(response.status);
            }
        }).send();
    },

    addPlace: function(place) {
        this.places[place.place_id] = place;

        var marker = new google.maps.Marker({
            map: this.map
        });

        marker.setPosition(place.geometry.location);
        marker.setIcon({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        });

        marker.setVisible(true);

        new Element('li', {
            'class': 'list-group-item place',
            'data-place-id': place.place_id,
            'text': place.name
        }).inject(this.placeList, 'bottom');
    },

    getPlaceFromId: function(placeId) {
        if (!this.placesService) {
            this.placesService = new google.maps.places.PlacesService(this.map);
        };

        var self = this,
            request = {
                placeId: placeId
            };

        this.placesService.getDetails(request, function(place, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                self.addPlace(place);
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
