/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/search/index.js":
/*!********************************!*\
  !*** ./src/js/search/index.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils */ "./src/js/utils/index.js");
/**
 * Global variables.
 */

const {
  customElements,
  HTMLElement
} = window;
const searchTermsMap = new Map();
let searchTerms = [];
const clearButton = document.getElementById('inforepo-clear-filters');
const searchButtons = document.getElementsByName('search-button');
const termsSearchBox = document.getElementById('buscar');
const viewButton = document.getElementById('map-view-button');

/**
 * inforepoCheckboxAccordion Class.
 */
class inforepoCheckboxAccordion extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    // Elements.
    this.filterKey = this.getAttribute('key');
    this.content = this.querySelector('.checkbox-accordion__content');
    this.accordionHandle = this.querySelector('.checkbox-accordion__handle');
    if (!this.accordionHandle || !this.content || !this.filterKey) {
      return;
    }
    this.accordionHandle.addEventListener('click', event => (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, this, this.content));
  }

  /**
   * Observe Attributes.
   *
   * @return {string[]} Attributes to be observed.
   */
  static get observedAttributes() {
    return ['active'];
  }

  /**
   * Attributes callback.
   *
   * Fired on attribute change.
   *
   * @param {string} name Attribute Name.
   * @param {string} oldValue Attribute's Old Value.
   * @param {string} newValue Attribute's New Value.
   */
  attributeChangedCallback(name, oldValue, newValue) {
    /**
     * If the state of this checkbox filter is open, then set then
     * active state of this component to true, so it can be opened.
     */
    if ('active' === name) {
      this.content.style.height = 'auto';
    } else {
      this.content.style.height = '0px';
    }
  }
}

/**
 * inforepoCheckboxAccordionChild Class.
 */
class inforepoCheckboxAccordionChild extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();
    this.accordionHandle = this.querySelector('.checkbox-accordion__child-handle-icon');
    this.inputEl = this.querySelector('input');
    if (this.accordionHandle && this.content) {
      this.accordionHandle.addEventListener('click', event => (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, this, this.content));
    }
    if (this.inputEl) {
      this.inputEl.addEventListener('click', event => this.handleCheckboxInputClick(event));
    }
  }
  /**
   * Update the component.
   *
   */
  update() {
    if (!this.inputEl) {
      return;
    }
    this.inputKey = this.inputEl.getAttribute('data-key-term');
    this.inputValue = this.inputEl.getAttribute('value');
    this.selectedFiltersForCurrentkey = filters[this.inputKey] || [];
    this.parentEl = this.inputEl.closest('.checkbox-accordion') || {};
    this.parentContentEl = this.inputEl.closest('.checkbox-accordion__child-content') || {};

    /**
     * If the current input value is amongst the selected filters, the check it.
     * and set the attributes and styles to open the accordion.
     */
    if (this.selectedFiltersForCurrentkey.includes(parseInt(this.inputValue))) {
      this.inputEl.checked = true;
      this.parentEl.setAttribute('active', true);
      if (this.parentContentEl.style) {
        this.parentContentEl.style.height = 'auto';
      }
    } else {
      this.inputEl.checked = false;
      this.parentEl.removeAttribute('active');
    }
  }

  /**
   * Handle Checkbox input click.
   *
   * @param event
   */
  handleCheckboxInputClick(event) {}
}

/**
 * Get terms and parent taxonomies from input elements
 * that are checked when user clicks search button.
 *
 * 
 */
function getCheckedBoxes() {
  const checkboxesEl = document.getElementsByClassName('term-checkbox');
  for (let i = 0; i < checkboxesEl.length; i++) {
    searchTerms = [];
    let el = checkboxesEl[i];
    if (el.checked) {
      let term = el.getAttribute('data-key-term');
      let parentTaxonomy = el.getAttribute('parent-taxonomy');
      if (searchTermsMap.get(parentTaxonomy) != null) {
        searchTerms = searchTermsMap.get(parentTaxonomy);
      }
      searchTerms.push(term);
      searchTermsMap.set(parentTaxonomy, searchTerms);
    }
  }
}

/**
 * Function that pulls user-entered text from key terms 
 * search box and adds to searchTermsMap for search params
 * 
 * @author marieleponti
 * @package inforepo
 * 
 * @return void
 * 
 */
function getKeyTermsInput() {
  let textInputBox = document.getElementById('buscar');
  let userEnteredSearchTerms = textInputBox.value;
  if (userEnteredSearchTerms != null) {
    searchTermsMap.set('s', userEnteredSearchTerms);
  }
}
if (clearButton != null) {
  clearButton.addEventListener('click', () => {
    var checkboxes = document.getElementsByClassName("term-checkbox");
    for (var checkbox of checkboxes) {
      checkbox.checked = false;
    }
    termsSearchBox.placeholder = "key terms";
    termsSearchBox.value = "";
  });
}
searchButtons.forEach(function (searchButton) {
  if (searchButton != null) {
    searchButton.addEventListener('click', () => {
      // getCheckedBoxes();
      // getKeyTermsInput();
      // let params = new URLSearchParams(searchTermsMap);
      // let baseUrl = location.protocol + '//' + location.host + location.pathname;
      // //window.location.href = location.href + '?' + params.toString();
      // window.location.href = baseUrl + '?' + params.toString();
      // console.log("baseURL: " + baseUrl);
      goSearch();
    });
    searchButton.addEventListener("keypress", function (event) {
      if (event.key == 13) {
        goSearch();
      }
    });
  }
});
function goSearch() {
  getCheckedBoxes();
  getKeyTermsInput();
  let params = new URLSearchParams(searchTermsMap);
  // let baseUrl = location.protocol + '//' + location.host + location.pathname;
  let baseUrl = location.protocol + '//' + location.host + '/resources/';
  //window.location.href = location.href + '?' + params.toString();
  window.location.href = baseUrl + '?' + params.toString();
  console.log("baseURL: " + baseUrl);
}
document.addEventListener('DOMContentLoaded', function () {
  checkBoxesAndResetKeyTermsCurrentSearch();
});

/**
 * 
 * Function to get params from search query
 * Sets map of taxonomies and terms with search query args
 * Checks boxes of current search params
 * 
 */
function checkBoxesAndResetKeyTermsCurrentSearch() {
  /**
   * get params from url
   */
  const url = new URL(window.location);
  // Create a test URLSearchParams object
  const searchParams = new URLSearchParams(url.search);
  if (searchParams.has('s')) {
    let lastSearchTerms = searchParams.get('s');
    termsSearchBox.placeholder = lastSearchTerms;
    termsSearchBox.value = lastSearchTerms;
  }

  // save search params from url to taxonomy:terms map
  for (const [key, value] of searchParams.entries()) {
    console.log(`${key}: ${value}`);
    const termsArray = searchParams.getAll(key);
    console.log("termsArray: " + termsArray);
    termsArray.forEach(checkTerms);
  }
}
function checkTerms(termsToCheck) {
  const termList = termsToCheck.split(',');
  for (let i = 0; i < termList.length; i++) {
    let el = document.getElementById(termList[i]);
    console.log("termList[i]: " + termList[i]);
    if (el != null) {
      el.checked = true;
      // if taxonomy item is checked, on reload dropdown should be open
      let parentDropdown = el.closest("inforepo-checkbox-accordion");
      parentDropdown.setAttribute('active', true);
    }
  }
}
if (termsSearchBox != null) {
  termsSearchBox.addEventListener('focus', function () {
    this.placeholder = "key terms";
  });
}
viewButton.addEventListener('click', event => goToMapView(event));
function goToMapView(event) {
  // let baseUrl = location.protocol + '//' + location.host + location.pathname;
  let baseUrl = location.protocol + '//' + location.host;
  window.location.href = baseUrl + '/resources-map';
}

/**
 * Initialize.
 * 
 * */
customElements.define('inforepo-checkbox-accordion', inforepoCheckboxAccordion);
customElements.define('inforepo-checkbox-accordion-child', inforepoCheckboxAccordionChild);

/***/ }),

/***/ "./src/js/utils/index.js":
/*!*******************************!*\
  !*** ./src/js/utils/index.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   slideElementDown: function() { return /* binding */ slideElementDown; },
/* harmony export */   slideElementUp: function() { return /* binding */ slideElementUp; },
/* harmony export */   toggleAccordionContent: function() { return /* binding */ toggleAccordionContent; },
/* harmony export */   toggleDivContent: function() { return /* binding */ toggleDivContent; }
/* harmony export */ });
/**
 * Toggle Accordion Content.
 *
 * @param {Event} event Event.
 * @param {Object} accordionEl Accordion Element
 * @param {Object} contentEl Content Element.
 *
 * @return {null} null
 */
const toggleAccordionContent = (event, accordionEl, contentEl) => {
  event.preventDefault();
  event.stopPropagation();
  if (!accordionEl || !contentEl) {
    return null;
  }
  accordionEl.toggleAttribute('active');
  if (!accordionEl.hasAttribute('active')) {
    slideElementUp(contentEl, 600);
  } else {
    slideElementDown(contentEl, 600);
  }
};
const toggleDivContent = (event, el) => {
  event.preventDefault();
  event.stopPropagation();
  if (!el) {
    return null;
  }
  el.toggleAttribute('active');
  if (!el.hasAttribute('active')) {
    slideElementUp(el, 600);
  } else {
    slideElementDown(el, 600);
  }
};

/**
 * Slide element down.
 *
 * @param {Object} element Target element.
 * @param {number} duration Animation duration.
 * @param {Function} callback Callback function.
 */
const slideElementDown = (element, duration = 300, callback = null) => {
  element.style.height = `${element.scrollHeight}px`;
  setTimeout(() => {
    element.style.height = 'auto';
    if (callback) {
      callback();
    }
  }, duration);
};

/**
 * Slide element up.
 *
 * @param {Object} element Target element.
 * @param {number} duration Animation duration.
 * @param {Function} callback Callback function.
 */
const slideElementUp = (element, duration = 300, callback = null) => {
  element.style.height = `${element.scrollHeight}px`;
  element.offsetHeight; // eslint-disable-line
  element.style.height = '0px';
  setTimeout(() => {
    element.style.height = null;
    if (callback) {
      callback();
    }
  }, duration);
};

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
/*!**************************!*\
  !*** ./src/js/search.js ***!
  \**************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _search_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search/index */ "./src/js/search/index.js");
/* harmony import */ var _sass_search_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../sass/search.scss */ "./src/sass/search.scss");


/******/ })()
;
//# sourceMappingURL=search.js.map