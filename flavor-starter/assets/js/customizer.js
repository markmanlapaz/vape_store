/**
 * Flavor Starter — Customizer live preview.
 */

(function ($) {
	'use strict';

	// Color live previews.
	var colorMap = {
		fs_color_accent_primary:   '--fs-accent-primary',
		fs_color_accent_secondary: '--fs-accent-secondary',
		fs_color_accent_tertiary:  '--fs-accent-tertiary',
		fs_color_bg_primary:       '--fs-bg-primary',
		fs_color_bg_secondary:     '--fs-bg-secondary',
		fs_color_bg_card:          '--fs-bg-card',
		fs_color_text_primary:     '--fs-text-primary',
		fs_color_text_secondary:   '--fs-text-secondary',
	};

	$.each(colorMap, function (setting, cssVar) {
		wp.customize(setting, function (value) {
			value.bind(function (to) {
				document.documentElement.style.setProperty(cssVar, to);
			});
		});
	});

})(jQuery);
