// Map Scripts
function myMap() {
    var latLng = {lat: 49.104366, lng: -97.557376};

        var mapOptions = {
            center: latLng,
            zoom: 18,
        scrollwheel: false,
        mapTypeControl: false
        }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: "Taekwondo Club Altona"
    })
}