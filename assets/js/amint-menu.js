(function ($) {
  'use strict';

  var initialized = false;

  $(function () {
    if (initialized) return;
    initialized = true;

    var $menu = $('.menu-will-stick');
    if ($menu.length === 0) return;

    var HERO_SELECTOR = '.hero';
    var UP_REVEAL_DELTA = 10; // px scroll up to reveal
    var DEADZONE = 4;         // ignore tiny wheel reversals
    var HIDE_VH = 2;          // hide after this many viewport heights (2×vh per latest change)

    var lastTop = window.pageYOffset || $(window).scrollTop();
    var showThreshold = 0;
    var hideThreshold = 0;

    function computeThresholds() {
      var vh = window.innerHeight || document.documentElement.clientHeight;
      var $hero = $(HERO_SELECTOR);
      showThreshold = $hero.length
        ? ($hero.first().offset().top + $hero.first().outerHeight())
        : vh * 0.5;
      hideThreshold = vh * HIDE_VH;
    }

    function showMenu() {
      if (!$menu.hasClass('menu-sticked')) $menu.addClass('menu-sticked');
    }

    function hideMenu() {
      if ($menu.hasClass('menu-sticked')) $menu.removeClass('menu-sticked');
    }

    function handleScroll() {
      var st = window.pageYOffset || $(window).scrollTop();
      var delta = st - lastTop;
      var absDelta = Math.abs(delta);

      if (absDelta <= DEADZONE) {
        lastTop = st;
        return;
      }

      var isVisible = $menu.hasClass('menu-sticked');

      // Below show threshold → always hide
      if (st <= showThreshold) {
        if (isVisible) hideMenu();
        lastTop = st;
        return;
      }

      // Above show threshold
      if (delta > 0) {
        // Scrolling down
        if (st >= hideThreshold && isVisible) {
          hideMenu();
        } else if (!isVisible && st > showThreshold && st < hideThreshold) {
          // First time crossing threshold on the way down → show
          showMenu();
        }
      } else {
        // Scrolling up
        if (!isVisible && st > showThreshold && absDelta >= UP_REVEAL_DELTA) {
          showMenu();
        }
      }

      lastTop = st;
    }

    // rAF-throttled passive scroll
    var ticking = false;
    function onScroll() {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        handleScroll();
        ticking = false;
      });
    }

    function onResize() {
      computeThresholds();
      handleScroll();
    }

    // Init
    computeThresholds();
    handleScroll();

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onResize);
  });
})(jQuery);
