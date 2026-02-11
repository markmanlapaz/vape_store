/**
 * Flavor Starter — Quick View Modal.
 *
 * Loads product quick-view via AJAX and manages the modal.
 */

(function ($) {
	'use strict';

	if (typeof flavorStarter === 'undefined') return;

	const { ajaxUrl, nonce } = flavorStarter;
	const $modal = $('.fs-quick-view-modal');
	const $body  = $modal.find('.fs-quick-view-modal__body');

	/* ------------------------------------------------------------------
	 * Open Quick View
	 * ----------------------------------------------------------------*/
	$(document).on('click', '.fs-quick-view-btn', function (e) {
		e.preventDefault();
		e.stopPropagation();

		const productId = $(this).data('product-id');
		if (!productId) return;

		// Show modal with loader.
		$body.html('<div class="fs-quick-view__loader">' + flavorStarter.i18n.loading + '</div>');
		$modal.attr('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';

		// Fetch product data.
		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: {
				action: 'flavor_quick_view',
				nonce: nonce,
				product_id: productId,
			},
			success: function (res) {
				if (res.success && res.data.html) {
					$body.html(res.data.html);
					initQuickViewGallery();
				} else {
					$body.html('<p style="text-align:center;padding:2rem;color:var(--fs-text-muted);">Could not load product.</p>');
				}
			},
			error: function () {
				$body.html('<p style="text-align:center;padding:2rem;color:var(--fs-text-muted);">Network error. Please try again.</p>');
			},
		});
	});

	/* ------------------------------------------------------------------
	 * Quick View Gallery Thumbnails
	 * ----------------------------------------------------------------*/
	function initQuickViewGallery() {
		$body.find('.fs-quick-view__thumb').on('click', function () {
			const fullSrc = $(this).data('full');
			const $mainImg = $body.find('#fs-qv-main-img');

			if (fullSrc && $mainImg.length) {
				$mainImg.attr('src', fullSrc);
			}

			$body.find('.fs-quick-view__thumb').removeClass('fs-quick-view__thumb--active');
			$(this).addClass('fs-quick-view__thumb--active');
		});
	}

})(jQuery);
