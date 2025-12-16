/**
 * Global variables.
 */
import {
	toggleAccordionContent
} from '../utils';

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

		this.accordionHandle.addEventListener('click', (event) => toggleAccordionContent(event, this, this.content));
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
			this.accordionHandle.addEventListener('click', (event) => toggleAccordionContent(event, this, this.content));
		}

		if (this.inputEl) {
			this.inputEl.addEventListener('click', (event) => this.handleCheckboxInputClick(event));
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
	handleCheckboxInputClick(event) {

	}

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

viewButton.addEventListener('click', (event) => goToMapView(event));

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