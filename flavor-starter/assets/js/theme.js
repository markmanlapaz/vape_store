/**
 * Flavor Starter — Main theme JavaScript.
 *
 * Handles: sticky header, mobile menu, search overlay, back-to-top,
 * top-bar close, overlay management, view toggle, shop sidebar toggle.
 */

(function () {
	'use strict';

	/* ------------------------------------------------------------------
	 * DOM References
	 * ----------------------------------------------------------------*/
	const header       = document.getElementById('masthead');
	const mobileNav    = document.querySelector('.fs-mobile-nav');
	const overlay      = document.querySelector('.fs-overlay');
	const cartDrawer   = document.querySelector('.fs-cart-drawer');
	const searchOverlay = document.querySelector('.fs-search-overlay');
	const backToTop    = document.querySelector('.fs-back-to-top');
	const topBar       = document.querySelector('.fs-topbar');
	const shopSidebar  = document.querySelector('.fs-shop__sidebar');

	/* ------------------------------------------------------------------
	 * Sticky Header on Scroll
	 * ----------------------------------------------------------------*/
	let lastScroll = 0;

	function handleScroll() {
		const scrollY = window.scrollY;

		// Add 'scrolled' class after 50px.
		if (header) {
			header.classList.toggle('scrolled', scrollY > 50);
		}

		// Back to top visibility.
		if (backToTop) {
			backToTop.classList.toggle('visible', scrollY > 500);
		}

		lastScroll = scrollY;
	}

	window.addEventListener('scroll', handleScroll, { passive: true });

	/* ------------------------------------------------------------------
	 * Global Action Dispatcher
	 * ----------------------------------------------------------------*/
	document.addEventListener('click', function (e) {
		const target = e.target.closest('[data-action]');
		if (!target) return;

		const action = target.dataset.action;

		switch (action) {
			case 'toggle-mobile-menu':
				toggleMobileMenu();
				break;

			case 'toggle-cart':
				toggleCartDrawer();
				break;

			case 'toggle-search':
				toggleSearch();
				break;

			case 'close-all':
				closeAll();
				break;

			case 'close-quick-view':
				closeQuickView();
				break;

			case 'back-to-top':
				window.scrollTo({ top: 0, behavior: 'smooth' });
				break;

			case 'toggle-shop-sidebar':
				if (shopSidebar) {
					shopSidebar.classList.toggle('active');
				}
				break;

			case 'qty-decrease': {
				const input = target.parentElement.querySelector('.fs-qty-input__field');
				if (input) {
					const val = parseInt(input.value, 10) || 1;
					input.value = Math.max(1, val - 1);
				}
				break;
			}

			case 'qty-increase': {
				const input = target.parentElement.querySelector('.fs-qty-input__field');
				if (input) {
					const val = parseInt(input.value, 10) || 1;
					const max = parseInt(input.max, 10) || 99;
					input.value = Math.min(max, val + 1);
				}
				break;
			}
		}
	});

	/* ------------------------------------------------------------------
	 * Mobile Menu
	 * ----------------------------------------------------------------*/
	function toggleMobileMenu() {
		const isOpen = mobileNav && mobileNav.getAttribute('aria-hidden') === 'false';
		if (isOpen) {
			closeMobileMenu();
		} else {
			openMobileMenu();
		}
	}

	function openMobileMenu() {
		if (!mobileNav) return;
		mobileNav.setAttribute('aria-hidden', 'false');
		overlay && overlay.classList.add('active');
		document.body.style.overflow = 'hidden';

		const burger = document.querySelector('.fs-header__burger');
		if (burger) burger.setAttribute('aria-expanded', 'true');
	}

	function closeMobileMenu() {
		if (!mobileNav) return;
		mobileNav.setAttribute('aria-hidden', 'true');
		overlay && overlay.classList.remove('active');
		document.body.style.overflow = '';

		const burger = document.querySelector('.fs-header__burger');
		if (burger) burger.setAttribute('aria-expanded', 'false');
	}

	/* ------------------------------------------------------------------
	 * Cart Drawer
	 * ----------------------------------------------------------------*/
	function toggleCartDrawer() {
		if (!cartDrawer) return;
		const isOpen = cartDrawer.getAttribute('aria-hidden') === 'false';
		if (isOpen) {
			closeCartDrawer();
		} else {
			openCartDrawer();
		}
	}

	function openCartDrawer() {
		if (!cartDrawer) return;
		cartDrawer.setAttribute('aria-hidden', 'false');
		overlay && overlay.classList.add('active');
		document.body.style.overflow = 'hidden';
	}

	function closeCartDrawer() {
		if (!cartDrawer) return;
		cartDrawer.setAttribute('aria-hidden', 'true');
		overlay && overlay.classList.remove('active');
		document.body.style.overflow = '';
	}

	// Expose for AJAX cart module.
	window.flavorStarterCart = { open: openCartDrawer, close: closeCartDrawer };

	/* ------------------------------------------------------------------
	 * Search Overlay
	 * ----------------------------------------------------------------*/
	function toggleSearch() {
		if (!searchOverlay) return;
		const isOpen = searchOverlay.getAttribute('aria-hidden') === 'false';
		searchOverlay.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
		if (!isOpen) {
			const input = searchOverlay.querySelector('input[type="search"]');
			if (input) input.focus();
		}
	}

	/* ------------------------------------------------------------------
	 * Close Everything
	 * ----------------------------------------------------------------*/
	function closeAll() {
		closeMobileMenu();
		closeCartDrawer();
		closeQuickView();
	}

	/* ------------------------------------------------------------------
	 * Quick View
	 * ----------------------------------------------------------------*/
	function closeQuickView() {
		const modal = document.querySelector('.fs-quick-view-modal');
		if (modal) {
			modal.setAttribute('aria-hidden', 'true');
			document.body.style.overflow = '';
		}
	}

	/* ------------------------------------------------------------------
	 * Top Bar Close
	 * ----------------------------------------------------------------*/
	if (topBar) {
		const closeBtn = topBar.querySelector('.fs-topbar__close');
		if (closeBtn) {
			closeBtn.addEventListener('click', function () {
				topBar.style.display = 'none';
			});
		}
	}

	/* ------------------------------------------------------------------
	 * Escape Key
	 * ----------------------------------------------------------------*/
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			closeAll();
			if (searchOverlay) searchOverlay.setAttribute('aria-hidden', 'true');
		}
	});

	/* ------------------------------------------------------------------
	 * View Toggle (Grid / List)
	 * ----------------------------------------------------------------*/
	const viewBtns = document.querySelectorAll('.fs-shop__view-btn');
	viewBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			const view = this.dataset.view;
			const grid = document.querySelector('.fs-shop__products ul.products');

			viewBtns.forEach(function (b) { b.classList.remove('fs-shop__view-btn--active'); });
			this.classList.add('fs-shop__view-btn--active');

			if (grid) {
				if (view === 'list') {
					grid.style.gridTemplateColumns = '1fr';
				} else {
					grid.style.gridTemplateColumns = '';
				}
			}
		});
	});

	/* ------------------------------------------------------------------
	 * Smooth scroll for anchor links
	 * ----------------------------------------------------------------*/
	document.querySelectorAll('a[href^="#"]').forEach(function (link) {
		link.addEventListener('click', function (e) {
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		});
	});

	/* ------------------------------------------------------------------
	 * Intersection Observer for fade-in animations
	 * ----------------------------------------------------------------*/
	if ('IntersectionObserver' in window) {
		const animateElements = document.querySelectorAll('.fs-section, .fs-trust-bar, .fs-newsletter');
		const observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('fs-visible');
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
		);

		animateElements.forEach(function (el) {
			el.style.opacity = '0';
			el.style.transform = 'translateY(20px)';
			el.style.transition = 'opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
			observer.observe(el);
		});
	}

	// Class to trigger animation.
	const style = document.createElement('style');
	style.textContent = '.fs-visible { opacity: 1 !important; transform: translateY(0) !important; }';
	document.head.appendChild(style);

})();
