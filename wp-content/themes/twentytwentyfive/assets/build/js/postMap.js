/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/search/map-single-post.js":
/*!******************************************!*\
  !*** ./src/js/search/map-single-post.js ***!
  \******************************************/
/***/ (function() {

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
    var lng = locationParsedS.features[0].geometry.coordinates[0];
    var lat = locationParsedS.features[0].geometry.coordinates[1];
    coordinates = [lat, lng];
  }
  if (coordinates != null) {
    var myIcon = L.icon({
      iconUrl: '/wp-content/themes/divi-child/assets/images/marker.svg',
      iconSize: [24, 36],
      iconAnchor: [12, 36],
      popupAnchor: [-3, -76]
    });
    L.marker(coordinates, {
      icon: myIcon
    }).addTo(postMap);
  }
  function strTolatLngArray(startString) {
    // Converted array
    let splitArray = startString.split(', ');
    let lat = parseFloat(splitArray[0]);
    let lng = parseFloat(splitArray[1]);
    return [lat, lng];
  }
});

/***/ }),

/***/ "./src/sass/search.scss":
/*!******************************!*\
  !*** ./src/sass/search.scss ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!****************************!*\
  !*** ./src/js/post-map.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _search_map_single_post__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search/map-single-post */ "./src/js/search/map-single-post.js");
/* harmony import */ var _search_map_single_post__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_search_map_single_post__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _sass_search_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../sass/search.scss */ "./src/sass/search.scss");


}();
/******/ })()
;
//# sourceMappingURL=postMap.js.map