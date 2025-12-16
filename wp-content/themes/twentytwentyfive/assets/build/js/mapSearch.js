/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/search/map-search-index.js":
/*!*******************************************!*\
  !*** ./src/js/search/map-search-index.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var leaflet_dist_images_marker_icon_png__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! leaflet/dist/images/marker-icon.png */ "./node_modules/leaflet/dist/images/marker-icon.png");
/* harmony import */ var leaflet_dist_images_marker_shadow_png__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! leaflet/dist/images/marker-shadow.png */ "./node_modules/leaflet/dist/images/marker-shadow.png");
/* harmony import */ var leaflet_dist_images_marker_icon_2x_png__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! leaflet/dist/images/marker-icon-2x.png */ "./node_modules/leaflet/dist/images/marker-icon-2x.png");



jQuery(document).ready(function ($) {
  const resourceMap = L.map('resource-map').setView([32.5317397, -117.0195290], 3);
  const viewButton = document.getElementById("list-view-button");
  viewButton.addEventListener('click', event => goToListView(event));
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
      if (locationParsed.features.length != 0) {
        var lng = locationParsed.features[0].geometry.coordinates[0];
        var lat = locationParsed.features[0].geometry.coordinates[1];
        mapCoordinates([lat, lng], pTitleM, pLinkM);
      }
    }
  }
  function mapCoordinates(latlng, pinTitle, pinLink) {
    var popupText = "<a href=" + pinLink + ">" + pinTitle + "</a>";
    var myIcon = L.icon({
      iconUrl: '/wp-content/themes/divi-child/assets/images/marker.svg',
      iconSize: [24, 36],
      iconAnchor: [12, 36],
      popupAnchor: [-3, -76]
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

/***/ }),

/***/ "./node_modules/leaflet/dist/images/marker-icon-2x.png":
/*!*************************************************************!*\
  !*** ./node_modules/leaflet/dist/images/marker-icon-2x.png ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("../../node_modules/leaflet/dist/images/marker-icon-2x.png");

/***/ }),

/***/ "./node_modules/leaflet/dist/images/marker-icon.png":
/*!**********************************************************!*\
  !*** ./node_modules/leaflet/dist/images/marker-icon.png ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("../../node_modules/leaflet/dist/images/marker-icon.png");

/***/ }),

/***/ "./node_modules/leaflet/dist/images/marker-shadow.png":
/*!************************************************************!*\
  !*** ./node_modules/leaflet/dist/images/marker-shadow.png ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("../../node_modules/leaflet/dist/images/marker-shadow.png");

/***/ }),

/***/ "./src/sass/search.scss":
/*!******************************!*\
  !*** ./src/sass/search.scss ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./src/js/map-search.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _search_map_search_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search/map-search-index */ "./src/js/search/map-search-index.js");
/* harmony import */ var _sass_search_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../sass/search.scss */ "./src/sass/search.scss");


/******/ })()
;
//# sourceMappingURL=mapSearch.js.map