const menuButton = document.querySelector('.menu-toggle');
const header = document.querySelector('.site-header');
const navLinks = [...document.querySelectorAll('.main-nav a[href^="#"]')];

const setActiveLink = (id) => {
  navLinks.forEach((link) => {
    link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
  });
};

const updateHeaderState = () => {
  if (!header) return;
  header.classList.toggle('is-scrolled', window.scrollY > 24);
};

if (menuButton) {
  menuButton.addEventListener('click', () => {
    const isOpen = document.body.classList.toggle('nav-open');
    menuButton.setAttribute('aria-expanded', String(isOpen));
  });

  document.querySelectorAll('.main-nav a').forEach((link) => {
    link.addEventListener('click', () => {
      document.querySelectorAll('.main-nav a').forEach((item) => {
        item.classList.remove('active');
      });
      link.classList.add('active');
      document.body.classList.remove('nav-open');
      menuButton.setAttribute('aria-expanded', 'false');
    });
  });
}

window.addEventListener('scroll', updateHeaderState, { passive: true });
updateHeaderState();

const sections = [...document.querySelectorAll('main section[id]')];

if ('IntersectionObserver' in window) {
  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        setActiveLink(entry.target.id);
      }
    });
  }, {
    rootMargin: '-30% 0px -55% 0px',
    threshold: 0,
  });

  sections.forEach((section) => sectionObserver.observe(section));
}

document.querySelectorAll('.color-carousel').forEach((carousel) => {
  const track = carousel.querySelector('.color-track');
  const previous = carousel.querySelector('.color-arrow-left');
  const next = carousel.querySelector('.color-arrow-right');

  if (!track || !previous || !next) return;

  const getStep = () => {
    const card = track.querySelector('.color-card');
    if (!card) return track.clientWidth;

    const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
    return card.getBoundingClientRect().width + gap;
  };

  previous.addEventListener('click', () => {
    track.scrollBy({ left: -getStep(), behavior: 'smooth' });
  });

  next.addEventListener('click', () => {
    track.scrollBy({ left: getStep(), behavior: 'smooth' });
  });
});
