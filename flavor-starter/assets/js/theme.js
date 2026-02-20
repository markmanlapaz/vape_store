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
	const header        = document.getElementById('masthead');
	const mobileNav     = document.querySelector('.fs-mobile-nav');
	const overlay       = document.querySelector('.fs-overlay');
	const cartDrawer    = document.querySelector('.fs-cart-drawer');
	const searchOverlay = document.querySelector('.fs-search-overlay');
	const backToTop     = document.querySelector('.fs-back-to-top');
	const topBar        = document.querySelector('.fs-topbar');
	const shopSidebar   = document.querySelector('.fs-shop__sidebar');
	const sidebarOverlay = document.querySelector('.fs-sidebar-overlay');

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
				toggleShopSidebar();
				break;

			case 'qty-decrease': {
				const input = target.parentElement.querySelector('.fs-qty-input__field');
				if (input) {
					const val = parseInt(input.value, 10) || 1;
					const min = parseInt(input.min, 10) || 1;
					input.value = Math.max(min, val - 1);
					input.dispatchEvent(new Event('change', { bubbles: true }));
				}
				break;
			}

			case 'qty-increase': {
				const input = target.parentElement.querySelector('.fs-qty-input__field');
				if (input) {
					const val = parseInt(input.value, 10) || 1;
					const max = parseInt(input.max, 10) || 9999;
					input.value = Math.min(max, val + 1);
					input.dispatchEvent(new Event('change', { bubbles: true }));
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

	/* ------------------------------------------------------------------
	 * Shop Sidebar (filters panel)
	 * ----------------------------------------------------------------*/
	function toggleShopSidebar() {
		if (!shopSidebar) return;
		const isOpen = shopSidebar.classList.contains('active');
		if (isOpen) {
			closeShopSidebar();
		} else {
			openShopSidebar();
		}
	}

	function openShopSidebar() {
		if (!shopSidebar) return;
		shopSidebar.classList.add('active');
		sidebarOverlay && sidebarOverlay.classList.add('active');
		// Only lock scroll on mobile (sidebar is a panel, not inline).
		if (window.innerWidth < 1024) {
			document.body.style.overflow = 'hidden';
		}
		const toggleBtn = document.querySelector('.fs-shop__filter-toggle');
		if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
	}

	function closeShopSidebar() {
		if (!shopSidebar) return;
		shopSidebar.classList.remove('active');
		sidebarOverlay && sidebarOverlay.classList.remove('active');
		document.body.style.overflow = '';
		const toggleBtn = document.querySelector('.fs-shop__filter-toggle');
		if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
	}

	// Close sidebar when clicking the backdrop overlay.
	if (sidebarOverlay) {
		sidebarOverlay.addEventListener('click', closeShopSidebar);
	}

	/* ------------------------------------------------------------------
	 * Filter Group Accordion (collapse / expand individual sections)
	 * ----------------------------------------------------------------*/
	document.querySelectorAll('.fs-filter-group__toggle').forEach(function (btn) {
		btn.addEventListener('click', function () {
			const group   = btn.closest('.fs-filter-group');
			const body    = btn.nextElementSibling;
			const isOpen  = !group.classList.contains('collapsed');

			group.classList.toggle('collapsed', isOpen);
			btn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
		});
	});

	/* ------------------------------------------------------------------
	 * Mobile Nav: Submenu Accordion
	 * Injects a toggle button after each parent link and handles
	 * open/close of the nested .sub-menu.
	 * ----------------------------------------------------------------*/
	(function initMobileSubmenus() {
		const mobileMenu = document.querySelector('.fs-mobile-menu');
		if (!mobileMenu) return;

		mobileMenu.querySelectorAll('.menu-item-has-children').forEach(function (item) {
			const link    = item.querySelector(':scope > a');
			const subMenu = item.querySelector(':scope > .sub-menu');
			if (!link || !subMenu) return;

			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'fs-mobile-submenu-toggle';
			btn.setAttribute('aria-expanded', 'false');
			btn.setAttribute('aria-label', link.textContent.trim() + ' submenu');
			btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>';

			link.insertAdjacentElement('afterend', btn);

			btn.addEventListener('click', function () {
				const isOpen = subMenu.classList.toggle('open');
				btn.classList.toggle('open', isOpen);
				btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			});
		});
	}());

})();
