/**
 * Jardins Secrets — Custom JavaScript
 * @version 1.1.0
 */
(function() {
  'use strict';

  document.addEventListener('DOMContentLoaded', function() {

    /* === FAQ Accordion (accessible) === */
    document.querySelectorAll('.js-faq-question').forEach(function(btn) {
      // Ensure keyboard accessibility
      if (btn.tagName !== 'BUTTON') {
        btn.setAttribute('role', 'button');
        btn.setAttribute('tabindex', '0');
      }

      var item = btn.closest('.js-faq-item');
      var answer = item ? item.querySelector('.js-faq-answer') : null;

      if (answer) {
        var id = 'faq-answer-' + Math.random().toString(36).substr(2, 9);
        answer.id = id;
        btn.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-controls', id);
        answer.setAttribute('role', 'region');
        answer.setAttribute('aria-labelledby', btn.id || '');
      }

      function toggleFaq() {
        var isActive = item.classList.contains('active');
        item.classList.toggle('active');
        btn.setAttribute('aria-expanded', String(!isActive));
      }

      btn.addEventListener('click', toggleFaq);
      btn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggleFaq();
        }
      });
    });

    /* === Smooth Scroll === */
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
      anchor.addEventListener('click', function(e) {
        var targetId = this.getAttribute('href');
        if (targetId === '#') return;
        var target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          // Set focus for accessibility
          target.setAttribute('tabindex', '-1');
          target.focus({ preventScroll: true });
        }
      });
    });

    /* === Scroll Animations (IntersectionObserver) === */
    if ('IntersectionObserver' in window) {
      var animObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('js-visible');
            animObserver.unobserve(entry.target); // Only animate once
          }
        });
      }, {
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
      });

      document.querySelectorAll('.js-card, .js-testimonial, .js-section-title, .js-realisation-card').forEach(function(el) {
        animObserver.observe(el);
      });
    } else {
      // Fallback: show everything immediately
      document.querySelectorAll('.js-card, .js-testimonial, .js-section-title, .js-realisation-card').forEach(function(el) {
        el.classList.add('js-visible');
      });
    }

    /* === Respect prefers-reduced-motion === */
    var motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (motionQuery.matches) {
      document.querySelectorAll('.js-card, .js-testimonial, .js-section-title, .js-realisation-card').forEach(function(el) {
        el.classList.add('js-visible');
      });
    }

    /* === Back to Top (lazy-created) === */
    var backToTop = document.createElement('button');
    backToTop.className = 'js-back-to-top';
    backToTop.setAttribute('aria-label', 'Retour en haut de la page');
    backToTop.innerHTML = '&uarr;';
    backToTop.style.cssText = 'position:fixed;bottom:30px;right:30px;width:48px;height:48px;border-radius:50%;background:var(--js-green,#2d5016);color:#fff;border:none;font-size:20px;cursor:pointer;opacity:0;visibility:hidden;transition:opacity 0.3s,visibility 0.3s,transform 0.3s;z-index:999;box-shadow:0 2px 10px rgba(0,0,0,0.15);';
    document.body.appendChild(backToTop);

    backToTop.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    var scrollThrottle = false;
    window.addEventListener('scroll', function() {
      if (scrollThrottle) return;
      scrollThrottle = true;
      requestAnimationFrame(function() {
        if (window.scrollY > 400) {
          backToTop.style.opacity = '1';
          backToTop.style.visibility = 'visible';
        } else {
          backToTop.style.opacity = '0';
          backToTop.style.visibility = 'hidden';
        }
        scrollThrottle = false;
      });
    });

    /* === Tally.so embed init === */
    if (typeof Tally !== 'undefined') {
      Tally.loadEmbeds();
    }

  }); // DOMContentLoaded
})();
