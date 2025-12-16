jQuery(document).ready(function ($) {

    var coordinates = [8.9936, -79.51973];
    const postMap = L.map('resource-map-single-post').setView(coordinates, 1.5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(postMap);


    console.log(typeof mapLocationData);
    if (mapLocationData != null) {
        var locationParsedS = JSON.parse(mapLocationData.pinPoint);
        var lng =  locationParsedS.features[0].geometry.coordinates[0];
        var lat =  locationParsedS.features[0].geometry.coordinates[1];
        coordinates = [lat, lng];
        
    } 

  
    if (coordinates != null){
        var myIcon = L.icon({
            iconUrl: '/wp-content/themes/divi-child/assets/images/marker.svg', 
            iconSize: [24, 36],
            iconAnchor: [12, 36],
            popupAnchor: [-3, -76],
        });
        L.marker(coordinates, {icon: myIcon}).addTo(postMap);
    }


    function strTolatLngArray(startString) {
        // Converted array
        let splitArray = startString.split(', ');
        let lat = parseFloat(splitArray[0]);
        let lng = parseFloat(splitArray[1]);
        return [lat, lng];
    }

});