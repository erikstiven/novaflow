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

const lightbox = document.querySelector('.image-lightbox');
const lightboxImage = lightbox?.querySelector('img');
const lightboxClose = lightbox?.querySelector('.lightbox-close');

const closeLightbox = () => {
  if (!lightbox || !lightboxImage) return;
  lightbox.classList.remove('is-open');
  lightbox.setAttribute('aria-hidden', 'true');
  lightboxImage.src = '';
  lightboxImage.alt = '';
  document.body.style.overflow = '';
};

document.querySelectorAll('.color-zoom img, .project-zoom img').forEach((image) => {
  image.closest('.color-zoom, .project-zoom')?.addEventListener('click', () => {
    if (!lightbox || !lightboxImage) return;
    lightboxImage.src = image.src;
    lightboxImage.alt = image.alt;
    lightbox.classList.add('is-open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  });
});

lightboxClose?.addEventListener('click', closeLightbox);

lightbox?.addEventListener('click', (event) => {
  if (event.target === lightbox) closeLightbox();
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') closeLightbox();
});

const formModal = document.querySelector('[data-form-modal]');

const closeFormModal = () => {
  if (!formModal) return;
  formModal.classList.remove('is-open');
  formModal.setAttribute('aria-hidden', 'true');
  document.body.classList.remove('form-modal-open');

  if (window.location.search.includes('form=')) {
    window.history.replaceState(null, '', window.location.pathname);
  }
};

formModal?.querySelector('.form-modal-close')?.addEventListener('click', closeFormModal);

formModal?.addEventListener('click', (event) => {
  if (event.target === formModal) closeFormModal();
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') closeFormModal();
});
