(function () {
  if (!('IntersectionObserver' in window)) {
    return;
  }

  var sections = document.querySelectorAll('main > section');
  var viewportCutoff = window.innerHeight * 0.9;
  var pending = [];

  sections.forEach(function (el) {
    if (el.getBoundingClientRect().top < viewportCutoff) {
      return;
    }

    el.classList.add('reveal-pending');
    pending.push(el);
  });

  if (pending.length === 0) {
    return;
  }

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) {
          return;
        }

        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -80px 0px' }
  );

  pending.forEach(function (el) { observer.observe(el); });
})();
