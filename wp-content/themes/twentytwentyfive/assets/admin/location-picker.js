/**
 * location-picker.js
 * -----------------------------------------------------------------------
 * Reemplaza la UI de Mapster para el campo "Ubicación" (group: search,
 * lat, lng, map_placeholder). Dos formas de fijar el pin:
 *
 *  1. Autocompletado: escribís una ciudad/país, elegís una sugerencia de
 *     Nominatim (OpenStreetMap) y lat/lng se llenan solas.
 *  2. Mapa: click (o arrastrar el marker) para ajustar a mano.
 *
 * Usa acf.getField(key) / field.val() — la API pública de ACF para leer y
 * escribir valores de campo, en vez de tocar el DOM de los inputs a mano.
 * -----------------------------------------------------------------------
 */
(function ($) {
	'use strict';

	var DEFAULT_CENTER = [15, -85]; // centrado vagamente en América, igual de arbitrario que el fallback Panamá del Mapster original
	var DEFAULT_ZOOM = 3;
	var SEARCH_DEBOUNCE_MS = 500; // Nominatim pide no pasar de ~1 request/segundo

	function initLocationField(searchField) {
		// Evita inicializar dos veces si ACF dispara "ready" y "append" para el mismo campo.
		if (searchField.$el.data('inforepoLocationInitialized')) {
			return;
		}
		searchField.$el.data('inforepoLocationInitialized', true);

		var latField = acf.getField('field_location_lat');
		var lngField = acf.getField('field_location_lng');

		if (!latField || !lngField) {
			return;
		}

		var $group = searchField.$el.closest('.acf-field[data-key="field_location"]');
		var $mapContainer = $group.find('.inforepo-location-map');

		if (!$mapContainer.length) {
			return;
		}

		var initialLat = parseFloat(latField.val());
		var initialLng = parseFloat(lngField.val());
		var hasInitialCoords = !isNaN(initialLat) && !isNaN(initialLng);

		var map = L.map($mapContainer[0]).setView(
			hasInitialCoords ? [initialLat, initialLng] : DEFAULT_CENTER,
			hasInitialCoords ? 10 : DEFAULT_ZOOM
		);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		}).addTo(map);

		var marker = null;

		function setMarker(lat, lng) {
			if (marker) {
				map.removeLayer(marker);
			}
			marker = L.marker([lat, lng], { draggable: true }).addTo(map);
			marker.on('dragend', function () {
				var pos = marker.getLatLng();
				writeCoords(pos.lat, pos.lng);
			});
		}

		function writeCoords(lat, lng) {
			latField.val(round6(lat));
			lngField.val(round6(lng));
		}

		function round6(n) {
			return Math.round(n * 1e6) / 1e6;
		}

		if (hasInitialCoords) {
			setMarker(initialLat, initialLng);
		}

		map.on('click', function (e) {
			writeCoords(e.latlng.lat, e.latlng.lng);
			setMarker(e.latlng.lat, e.latlng.lng);
		});

		// ===== Autocompletado (Nominatim) =====
		var $input = searchField.$el.find('input[type="text"]');
		var $suggestions = $('<ul class="inforepo-location-suggestions"></ul>').insertAfter($input);
		var debounceTimer = null;
		var currentRequest = null;

		$input.on('input', function () {
			var query = $(this).val().trim();
			window.clearTimeout(debounceTimer);
			$suggestions.empty();

			if (query.length < 3) {
				return;
			}

			debounceTimer = window.setTimeout(function () {
				if (currentRequest) {
					currentRequest.abort();
				}

				currentRequest = $.ajax({
					url: 'https://nominatim.openstreetmap.org/search',
					data: {
						format: 'json',
						limit: 5,
						q: query,
					},
					dataType: 'json',
				}).done(function (results) {
					renderSuggestions(results || []);
				}).fail(function (jqXHR, statusText) {
					if (statusText !== 'abort') {
						console.error('Nominatim error:', statusText);
					}
				});
			}, SEARCH_DEBOUNCE_MS);
		});

		function renderSuggestions(results) {
			$suggestions.empty();

			results.forEach(function (place) {
				var $item = $('<li></li>').text(place.display_name);

				$item.on('click', function () {
					$input.val(place.display_name);
					writeCoords(parseFloat(place.lat), parseFloat(place.lon));
					setMarker(parseFloat(place.lat), parseFloat(place.lon));
					map.setView([place.lat, place.lon], 10);
					$suggestions.empty();
				});

				$suggestions.append($item);
			});
		}

		// Cierra la lista de sugerencias al hacer click afuera.
		$(document).on('click', function (e) {
			if (!$(e.target).closest('.inforepo-location-search, .inforepo-location-suggestions').length) {
				$suggestions.empty();
			}
		});

		// El mapa puede nacer con tamaño mal calculado si el campo estaba
		// dentro de una pestaña/acordeón oculto en el momento del render.
		window.setTimeout(function () {
			map.invalidateSize();
		}, 300);
	}

	acf.addAction('ready_field/key=field_location_search', initLocationField);
	acf.addAction('append_field/key=field_location_search', initLocationField);
})(jQuery);