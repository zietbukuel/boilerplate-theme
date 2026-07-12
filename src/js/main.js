/**
 * Boilerplate Theme - Main JavaScript
 * 
 * Handles frontend interactions: mobile navigation, smooth scroll,
 * lazy loading fallbacks, and block enhancements.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

(function() {
    'use strict';
    
    /**
     * ==========================================================================
     * UTILITY FUNCTIONS
     * ==========================================================================
     */
    
    /**
     * Debounce function to limit rate of execution
     * @param {Function} func - Function to debounce
     * @param {number} wait - Milliseconds to wait
     * @param {boolean} immediate - Execute immediately on first call
     * @returns {Function} Debounced function
     */
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
    
    /**
     * Check if element is in viewport
     * @param {Element} el - Element to check
     * @param {number} offset - Offset in pixels
     * @returns {boolean}
     */
    function isInViewport(el, offset) {
        offset = offset || 0;
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= -offset &&
            rect.left >= -offset &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + offset &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth) + offset
        );
    }
    
    /**
     * Get CSS custom property value
     * @param {string} property - CSS custom property name (e.g., '--color-primary')
     * @param {Element} [element] - Element to get property from (default: document.documentElement)
     * @returns {string} Property value
     */
    function getCSSProperty(property, element) {
        element = element || document.documentElement;
        return getComputedStyle(element).getPropertyValue(property).trim();
    }
    
    /**
     * ==========================================================================
     * MOBILE NAVIGATION
     * ==========================================================================
     */
    function initMobileNav() {
        var toggle = document.querySelector('.mobile-menu-toggle');
        var nav = document.getElementById('site-navigation');
        var menu = nav ? nav.querySelector('.nav-menu') : null;
        
        if (!toggle || !nav || !menu) {
            return;
        }
        
        var isOpen = false;
        
        function openMenu() {
            isOpen = true;
            toggle.setAttribute('aria-expanded', 'true');
            nav.classList.add('nav-open');
            menu.classList.add('nav-menu--open');
            document.body.classList.add('nav-open');
            // Trap focus
            trapFocus(menu);
        }
        
        function closeMenu() {
            isOpen = false;
            toggle.setAttribute('aria-expanded', 'false');
            nav.classList.remove('nav-open');
            menu.classList.remove('nav-menu--open');
            document.body.classList.remove('nav-open');
        }
        
        function toggleMenu() {
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        }
        
        // Toggle button click
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMenu();
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                closeMenu();
                toggle.focus();
            }
        });
        
        // Close on link click (for single page anchors)
        menu.querySelectorAll('a[href^="#"]').forEach(function(link) {
            link.addEventListener('click', function() {
                if (isOpen) {
                    closeMenu();
                }
            });
        });
        
        // Close on outside click
        document.addEventListener('click', function(e) {
            if (isOpen && !nav.contains(e.target) && !toggle.contains(e.target)) {
                closeMenu();
            }
        });
        
        // Handle window resize
        var handleResize = debounce(function() {
            if (window.innerWidth >= 1024 && isOpen) {
                closeMenu();
            }
        }, 100);
        
        window.addEventListener('resize', handleResize);
    }
    
    /**
     * Focus trap for modal/menu accessibility
     * @param {Element} container - Container to trap focus in
     */
    function trapFocus(container) {
        var focusableElements = container.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        var firstElement = focusableElements[0];
        var lastElement = focusableElements[focusableElements.length - 1];
        
        function handleTab(e) {
            if (e.key !== 'Tab') return;
            
            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
        
        container.addEventListener('keydown', handleTab);
        
        // Focus first element
        if (firstElement) {
            firstElement.focus();
        }
        
        // Store cleanup function
        container._focusTrapCleanup = function() {
            container.removeEventListener('keydown', handleTab);
        };
    }
    
    /**
     * ==========================================================================
     * SMOOTH SCROLL FOR ANCHOR LINKS
     * ==========================================================================
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                var target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    
                    // Calculate offset for fixed header
                    var header = document.getElementById('masthead');
                    var headerHeight = header ? header.offsetHeight : 0;
                    var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update URL without scrolling
                    history.pushState(null, null, targetId);
                    
                    // Focus target for accessibility
                    target.focus({ preventScroll: true });
                }
            });
        });
    }
    
    /**
     * ==========================================================================
     * LAZY LOADING FALLBACK
     * ==========================================================================
     */
    function initLazyLoadFallback() {
        // Only run if native lazy loading not supported
        if ('loading' in HTMLImageElement.prototype) {
            return;
        }
        
        var lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        if (!lazyImages.length) return;
        
        var observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.removeAttribute('loading');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '100px 0px',
            threshold: 0.01
        });
        
        lazyImages.forEach(function(img) {
            observer.observe(img);
        });
    }
    
    /**
     * ==========================================================================
     * BLOCK ENHANCEMENTS
     * ==========================================================================
     */
    function initBlockEnhancements() {
        // Hero section parallax (subtle)
        var heroSections = document.querySelectorAll('.block--hero-section');
        
        if (heroSections.length && window.innerWidth > 768) {
            var handleScroll = debounce(function() {
                heroSections.forEach(function(hero) {
                    var rect = hero.getBoundingClientRect();
                    var scrollPercent = 1 - (rect.bottom / (window.innerHeight + rect.height));
                    
                    // Only apply if hero is in viewport
                    if (scrollPercent >= 0 && scrollPercent <= 1) {
                        var background = hero.querySelector('.block-hero__background');
                        if (background) {
                            var offset = scrollPercent * 30; // Max 30px movement
                            background.style.transform = 'translateY(' + offset + 'px)';
                        }
                    }
                });
            }, 10);
            
            window.addEventListener('scroll', handleScroll, { passive: true });
        }
        
        // Feature grid hover effects (CSS handles most, this is for JS enhancements)
        var featureItems = document.querySelectorAll('.block-feature-grid__item');
        featureItems.forEach(function(item) {
            // Add keyboard support for linked items
            var link = item.querySelector('.block-feature-grid__link');
            if (link) {
                item.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        link.click();
                    }
                });
            }
        });
    }
    
    /**
     * ==========================================================================
     * HEADER SCROLL EFFECT
     * ==========================================================================
     */
    function initHeaderScroll() {
        var header = document.getElementById('masthead');
        if (!header) return;
        
        var lastScrollY = window.scrollY;
        var ticking = false;
        
        function updateHeader() {
            var currentScrollY = window.scrollY;
            
            if (currentScrollY > 100) {
                header.classList.add('site-header--scrolled');
            } else {
                header.classList.remove('site-header--scrolled');
            }
            
            // Hide/show on scroll direction (optional)
            if (currentScrollY > lastScrollY && currentScrollY > 200) {
                header.classList.add('site-header--hidden');
            } else {
                header.classList.remove('site-header--hidden');
            }
            
            lastScrollY = currentScrollY;
            ticking = false;
        }
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });
    }
    
    /**
     * ==========================================================================
     * INITIALIZATION
     * ==========================================================================
     */
    function init() {
        // Wait for DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }
        
        // Initialize all modules
        initMobileNav();
        initSmoothScroll();
        initLazyLoadFallback();
        initBlockEnhancements();
        initHeaderScroll();
        
        // Dispatch ready event for other scripts
        document.dispatchEvent(new CustomEvent('boilerplate:ready'));
    }
    
    // Start initialization
    init();
    
    // Expose utilities globally for other scripts
    window.Boilerplate = {
        debounce: debounce,
        isInViewport: isInViewport,
        getCSSProperty: getCSSProperty,
    };
    
})();