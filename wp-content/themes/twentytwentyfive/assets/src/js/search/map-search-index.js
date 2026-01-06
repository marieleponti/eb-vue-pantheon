import 'leaflet/dist/images/marker-icon.png';
import 'leaflet/dist/images/marker-shadow.png';
import 'leaflet/dist/images/marker-icon-2x.png';

jQuery(document).ready(function ($) {
    const resourceMap = L.map('resource-map').setView([32.5317397, -117.0195290], 3);
    const viewButton = document.getElementById("list-view-button");
    viewButton.addEventListener('click', (event) => goToListView(event));

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(resourceMap);

    var numberOfEntries = Cookies.get("quantityEntries");
    // console.log("qnty: " + numberOfEntries);

    for (var i = 0; i < numberOfEntries; i++) {

        var currentMapster = myMapDataMapster[i];
        var pLocationM = currentMapster.pinPoint;
        var pTitleM = currentMapster.pinTitle;
        var pLinkM = currentMapster.pinLink;
        if (pLocationM != null && pTitleM != null && pLinkM != null) {
            // console.log("current title: " + pTitleM);
            // console.log("current link: " + pLinkM);
            // console.log("coords: " + pLocationM);

            var locationParsed = JSON.parse(pLocationM);
            if (locationParsed.features.length != 0){
                var lng =  locationParsed.features[0].geometry.coordinates[0];
                var lat =  locationParsed.features[0].geometry.coordinates[1];
                mapCoordinates([lat, lng], pTitleM, pLinkM);
            }
          
        } 
       
    }


    function mapCoordinates(latlng, pinTitle, pinLink) {

        var popupText = "<a href=" + pinLink + ">" + pinTitle + "</a>";

        var myIcon = L.icon({
            iconUrl: '/wp-content/themes/twentytwentyfive/assets/images/marker.svg',
            iconSize: [24, 36],
            iconAnchor: [12, 36],
            popupAnchor: [-3, -76],
        });

        L.marker(latlng, {
            icon: myIcon
        }).bindPopup(popupText).addTo(resourceMap);

    }

    function strTolatLngArray(startString) {
        // Converted array
        let splitArray = startString.split(', ');
        let lat = parseFloat(splitArray[0]);
        let lng = parseFloat(splitArray[1]);
        return [lat, lng];
    }

    function goToListView(event) {
        let baseUrl = location.protocol + '//' + location.host + location.pathname;
        window.location.href = baseUrl + '/resources';
        console.log("base url: " + baseUrl);
    }

});