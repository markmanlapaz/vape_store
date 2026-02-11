/**
 * Flavor Starter — Age Verification Popup.
 *
 * Cookie-based gate. Blocks access until user confirms age.
 * Settings passed from WordPress via flavorAgeVerify localized object.
 */

(function () {
	'use strict';

	if (typeof flavorAgeVerify === 'undefined') return;

	var COOKIE_NAME = 'fs_age_verified';
	var config = flavorAgeVerify;

	// Check if already verified.
	if (getCookie(COOKIE_NAME)) return;

	// Build the overlay.
	var overlay = document.createElement('div');
	overlay.className = 'fs-age-verify';
	overlay.setAttribute('role', 'dialog');
	overlay.setAttribute('aria-modal', 'true');
	overlay.setAttribute('aria-label', config.title);

	overlay.innerHTML =
		'<div class="fs-age-verify__card">' +
			'<div class="fs-age-verify__icon">🔞</div>' +
			'<h2 class="fs-age-verify__title">' + escapeHTML(config.title) + '</h2>' +
			'<p class="fs-age-verify__message">' + escapeHTML(config.message) + '</p>' +
			'<div class="fs-age-verify__buttons">' +
				'<button class="fs-age-verify__confirm" id="fs-age-confirm">' + escapeHTML(config.confirmText) + '</button>' +
				'<button class="fs-age-verify__deny" id="fs-age-deny">' + escapeHTML(config.denyText) + '</button>' +
			'</div>' +
		'</div>';

	// Prevent scrolling.
	document.body.style.overflow = 'hidden';
	document.body.appendChild(overlay);

	// Confirm — set cookie, remove overlay.
	document.getElementById('fs-age-confirm').addEventListener('click', function () {
		setCookie(COOKIE_NAME, '1', parseInt(config.cookieDays, 10) || 30);
		overlay.style.opacity = '0';
		overlay.style.transition = 'opacity 0.3s ease';
		setTimeout(function () {
			overlay.remove();
			document.body.style.overflow = '';
		}, 300);
	});

	// Deny — redirect away.
	document.getElementById('fs-age-deny').addEventListener('click', function () {
		window.location.href = config.denyUrl || 'https://www.google.com';
	});

	/* ------------------------------------------------------------------
	 * Cookie Helpers
	 * ----------------------------------------------------------------*/
	function setCookie(name, value, days) {
		var d = new Date();
		d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
		document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
	}

	function getCookie(name) {
		var match = document.cookie.match(new RegExp('(?:^|;\\s*)' + name + '=([^;]*)'));
		return match ? match[1] : null;
	}

	function escapeHTML(str) {
		var div = document.createElement('div');
		div.appendChild(document.createTextNode(str));
		return div.innerHTML;
	}

})();
