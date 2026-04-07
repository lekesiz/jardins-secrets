// Jardins Secrets - Custom JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion
    document.querySelectorAll('.js-faq-question').forEach(function(q) {
        q.addEventListener('click', function() {
            this.closest('.js-faq-item').classList.toggle('active');
        });
    });
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(function(a) {
        a.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    // Scroll animations
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) { entry.target.classList.add('js-visible'); }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.js-card, .js-testimonial, .js-section-title').forEach(function(el) {
        observer.observe(el);
    });
});
