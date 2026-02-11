/**
 * Flavor Starter — AJAX Cart functionality.
 *
 * Handles add-to-cart, update quantity, remove item, wishlist toggle.
 */

(function ($) {
	'use strict';

	if (typeof flavorStarter === 'undefined') return;

	const { ajaxUrl, nonce } = flavorStarter;

	/* ------------------------------------------------------------------
	 * Add to Cart
	 * ----------------------------------------------------------------*/
	$(document).on('click', '.fs-add-to-cart-btn', function (e) {
		e.preventDefault();

		const $btn = $(this);
		const productId = $btn.data('product-id');

		if (!productId || $btn.hasClass('loading')) return;

		// Check if there's a qty input (quick view).
		const $qtyInput = $btn.closest('.fs-quick-view__add-to-cart, .fs-quick-view').find('.fs-qty-input__field');
		const quantity = $qtyInput.length ? parseInt($qtyInput.val(), 10) || 1 : 1;

		$btn.addClass('loading');
		const originalHTML = $btn.html();
		$btn.html('<span class="fs-spinner"></span>');

		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: {
				action: 'flavor_add_to_cart',
				nonce: nonce,
				product_id: productId,
				quantity: quantity,
			},
			success: function (res) {
				if (res.success) {
					// Update cart count.
					$('.fs-header__cart-count').text(res.data.cartCount);
					$('.fs-cart-drawer__count').text('(' + res.data.cartCount + ')');

					// Replace cart drawer HTML.
					if (res.data.cartDrawer) {
						$('.fs-cart-drawer').replaceWith(res.data.cartDrawer);
					}

					// Show success state.
					$btn.html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> <span>' + flavorStarter.i18n.addedToCart + '</span>');
					$btn.addClass('added');

					// Open cart drawer.
					if (window.flavorStarterCart) {
						window.flavorStarterCart.open();
					}

					setTimeout(function () {
						$btn.html(originalHTML);
						$btn.removeClass('loading added');
					}, 2000);
				} else {
					$btn.html(originalHTML);
					$btn.removeClass('loading');
				}
			},
			error: function () {
				$btn.html(originalHTML);
				$btn.removeClass('loading');
			},
		});
	});

	/* ------------------------------------------------------------------
	 * Cart Item Quantity Update
	 * ----------------------------------------------------------------*/
	$(document).on('click', '.fs-cart-item__qty-btn', function (e) {
		e.preventDefault();

		const $btn = $(this);
		const action = $btn.data('action');
		const cartItemKey = $btn.data('key');
		const $item = $btn.closest('.fs-cart-item');
		const $qtyDisplay = $item.find('.fs-cart-item__qty-value');
		let qty = parseInt($qtyDisplay.text(), 10) || 1;

		if (action === 'decrease-qty') {
			qty = Math.max(0, qty - 1);
		} else if (action === 'increase-qty') {
			qty = qty + 1;
		}

		// If qty is 0, this effectively removes.
		updateCartItem(cartItemKey, qty);
	});

	/* ------------------------------------------------------------------
	 * Remove Cart Item
	 * ----------------------------------------------------------------*/
	$(document).on('click', '[data-action="remove-item"]', function (e) {
		e.preventDefault();

		const cartItemKey = $(this).data('key');
		updateCartItem(cartItemKey, 0);
	});

	/* ------------------------------------------------------------------
	 * Update Cart Helper
	 * ----------------------------------------------------------------*/
	function updateCartItem(cartItemKey, quantity) {
		const ajaxAction = quantity === 0 ? 'flavor_remove_cart_item' : 'flavor_update_cart';
		const data = {
			action: ajaxAction,
			nonce: nonce,
			cart_item_key: cartItemKey,
		};

		if (quantity > 0) {
			data.quantity = quantity;
		}

		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: data,
			success: function (res) {
				if (res.success) {
					$('.fs-header__cart-count').text(res.data.cartCount);

					if (res.data.cartDrawer) {
						$('.fs-cart-drawer').replaceWith(res.data.cartDrawer);
					}
				}
			},
		});
	}

	/* ------------------------------------------------------------------
	 * Wishlist Toggle
	 * ----------------------------------------------------------------*/
	// Initialize wishlist state from cookie.
	function getWishlistFromCookie() {
		const match = document.cookie.match(/(?:^|;\s*)fs_wishlist=([^;]*)/);
		if (match) {
			try {
				return JSON.parse(decodeURIComponent(match[1]));
			} catch (e) {
				return [];
			}
		}
		return [];
	}

	function updateWishlistUI() {
		const ids = getWishlistFromCookie();
		$('.fs-header__wishlist-count').text(ids.length);

		$('.fs-wishlist-btn').each(function () {
			const pid = parseInt($(this).data('product-id'), 10);
			$(this).toggleClass('active', ids.includes(pid));
		});
	}

	// Initial state.
	updateWishlistUI();

	$(document).on('click', '.fs-wishlist-btn', function (e) {
		e.preventDefault();

		const $btn = $(this);
		const productId = $btn.data('product-id');

		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: {
				action: 'flavor_toggle_wishlist',
				nonce: nonce,
				product_id: productId,
			},
			success: function (res) {
				if (res.success) {
					$('.fs-header__wishlist-count').text(res.data.count);

					if (res.data.action === 'added') {
						$btn.addClass('active');
					} else {
						$btn.removeClass('active');
					}
				}
			},
		});
	});

	/* ------------------------------------------------------------------
	 * Spinner CSS (inject once)
	 * ----------------------------------------------------------------*/
	const spinnerCSS = document.createElement('style');
	spinnerCSS.textContent = `
		.fs-spinner {
			display: inline-block;
			width: 16px;
			height: 16px;
			border: 2px solid rgba(255,255,255,0.3);
			border-top-color: #fff;
			border-radius: 50%;
			animation: fs-spin 0.6s linear infinite;
		}
		@keyframes fs-spin {
			to { transform: rotate(360deg); }
		}
		.fs-add-to-cart-btn.loading { pointer-events: none; opacity: 0.8; }
		.fs-add-to-cart-btn.added { background: #22c55e; border-color: #22c55e; }
	`;
	document.head.appendChild(spinnerCSS);

})(jQuery);
