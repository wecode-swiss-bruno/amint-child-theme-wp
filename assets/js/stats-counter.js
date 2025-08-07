(function() {
    'use strict';

    // Debounce function to limit how often a function can run
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Animate counter
    function animateCounter(element, duration) {
        const target = parseFloat(element.dataset.value);
        const hasDecimal = element.dataset.value.includes('.');
        const decimalPlaces = hasDecimal ? element.dataset.value.split('.')[1].length : 0;
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            if (hasDecimal) {
                element.textContent = current.toFixed(decimalPlaces);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16); // ~60fps
    }

    // Initialize stats counters
    function initStatsCounters() {
        const counters = document.querySelectorAll('.stats-counter-element.has-animation');
        
        counters.forEach(counter => {
            if (counter.dataset.animated === 'true') return;
            
            const numbers = counter.querySelectorAll('.stats-counter-number');
            const duration = parseInt(counter.dataset.animationDuration) || 2000;
            
            // Create intersection observer for this counter
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && counter.dataset.animated !== 'true') {
                        counter.dataset.animated = 'true';
                        
                        numbers.forEach(number => {
                            animateCounter(number, duration);
                        });
                        
                        observer.disconnect();
                    }
                });
            }, {
                threshold: 0.5 // Trigger when 50% of element is visible
            });
            
            observer.observe(counter);
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStatsCounters);
    } else {
        initStatsCounters();
    }

    // Reinitialize for Bricks Builder
    if (typeof window.bricksIsFrontend !== 'undefined' && !window.bricksIsFrontend) {
        // In builder mode
        window.addEventListener('bricks:reinit', initStatsCounters);
    }

    // Handle dynamic content loaded via AJAX
    document.addEventListener('bricks:ajax:load:end', initStatsCounters);
    document.addEventListener('bricks:infinite-scroll:load:end', initStatsCounters);

})();