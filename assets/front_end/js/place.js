var placeSearch, autocomplete;

function initialize() {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
    /** @type {HTMLInputElement} */
    (document.getElementById('user_address')), {
        types: ['geocode']
    });

    google.maps.event.addDomListener(document.getElementById('user_address'), 'focus', geolocate);
    autocomplete.addListener('place_changed', get_latitude_longitude);
}

function get_latitude_longitude() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var key = "AIzaSyDYHKDyN1YX7hWTGtYdLb1F0UAOVwK1MKc";
         $.get('https://maps.googleapis.com/maps/api/geocode/json',{address:place.formatted_address,key:key},function(data, status){

            $(data.results).each(function(key,value){

                $.post(base_url+'home/set_location',{address:place.formatted_address,latitude:value.geometry.location.lat,longitude:value.geometry.location.lng});
            });
        });
    }

function geolocate() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {

            var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());

        });
    }
}

initialize();
    
    
    function current_location(session)
    {
 
        //debugger;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
        else {
            alert("Geolocation is not supported by this browser.");
        }


        function showPosition(position) {

           var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[3]) 
                    {
                        if(session==1)
                        {
                            $('#user_address').val(results[3].formatted_address);
                            $('#user_latitude').val(position.coords.latitude);
                            $('#user_longitude').val(position.coords.longitude);

                            $.post(base_url+'home/set_location',{address:results[3].formatted_address,latitude:position.coords.latitude,longitude:position.coords.longitude})
                        }
                        else
                        {
                            if(user_address=='' && user_latitude=='' && user_longitude=='')
                            {
                                $('#user_address').val(results[3].formatted_address);
                                $('#user_latitude').val(position.coords.latitude);
                                $('#user_longitude').val(position.coords.longitude);

                                $.post(base_url+'home/set_location',{address:results[3].formatted_address,latitude:position.coords.latitude,longitude:position.coords.longitude})
                            }
                        }
                        
                    }
                }
            });
        }

    }

    current_location(0);
