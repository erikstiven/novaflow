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

document.querySelectorAll('[data-video-carousel]').forEach((carousel) => {
  const track = carousel.querySelector('.video-track');
  const previous = carousel.querySelector('.video-arrow-left');
  const next = carousel.querySelector('.video-arrow-right');
  const dots = carousel.querySelector('.video-dots');
  const cards = [...carousel.querySelectorAll('.video-card')];
  const videos = [...carousel.querySelectorAll('video')];

  if (!track || !previous || !next || !dots || !cards.length) return;

  cards.forEach((_, index) => {
    const dot = document.createElement('button');
    dot.className = 'video-dot';
    dot.type = 'button';
    dot.setAttribute('aria-label', `Go to video ${index + 1}`);
    dot.addEventListener('click', () => {
      cards[index].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    });
    dots.appendChild(dot);
  });

  const dotButtons = [...dots.querySelectorAll('.video-dot')];

  const getActiveIndex = () => {
    const trackCenter = track.getBoundingClientRect().left + (track.clientWidth / 2);
    return cards.reduce((closestIndex, card, index) => {
      const cardRect = card.getBoundingClientRect();
      const cardCenter = cardRect.left + (cardRect.width / 2);
      const closestRect = cards[closestIndex].getBoundingClientRect();
      const closestCenter = closestRect.left + (closestRect.width / 2);
      return Math.abs(cardCenter - trackCenter) < Math.abs(closestCenter - trackCenter) ? index : closestIndex;
    }, 0);
  };

  const updateDots = () => {
    const activeIndex = getActiveIndex();
    dotButtons.forEach((dot, index) => {
      dot.classList.toggle('is-active', index === activeIndex);
    });
  };

  const scrollToVideo = (direction) => {
    const activeIndex = getActiveIndex();
    const nextIndex = Math.min(cards.length - 1, Math.max(0, activeIndex + direction));
    cards[nextIndex].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
  };

  previous.addEventListener('click', () => scrollToVideo(-1));
  next.addEventListener('click', () => scrollToVideo(1));
  track.addEventListener('scroll', () => window.requestAnimationFrame(updateDots), { passive: true });
  window.addEventListener('resize', updateDots, { passive: true });

  videos.forEach((video) => {
    video.addEventListener('play', () => {
      videos.forEach((otherVideo) => {
        if (otherVideo !== video) otherVideo.pause();
      });
    });
  });

  updateDots();
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

document.querySelectorAll('.compare-card').forEach((card) => {
  const handle = card.querySelector('.compare-handle');
  if (!handle) return;

  const syncWidth = () => {
    card.style.setProperty('--compare-card-width', `${card.getBoundingClientRect().width}px`);
  };

  const setPosition = (clientX) => {
    const rect = card.getBoundingClientRect();
    const rawPosition = ((clientX - rect.left) / rect.width) * 100;
    const position = Math.min(96, Math.max(4, rawPosition));
    card.style.setProperty('--compare-position', `${position}%`);
  };

  syncWidth();
  window.addEventListener('resize', syncWidth, { passive: true });
  card.querySelectorAll('img').forEach((image) => {
    if (image.complete) return;
    image.addEventListener('load', syncWidth, { once: true });
  });

  card.addEventListener('pointerdown', (event) => {
    syncWidth();
    setPosition(event.clientX);
    card.setPointerCapture(event.pointerId);
  });

  card.addEventListener('pointermove', (event) => {
    if (!card.hasPointerCapture(event.pointerId)) return;
    setPosition(event.clientX);
  });

  card.addEventListener('pointerup', (event) => {
    if (card.hasPointerCapture(event.pointerId)) {
      card.releasePointerCapture(event.pointerId);
    }
  });

  card.addEventListener('pointercancel', (event) => {
    if (card.hasPointerCapture(event.pointerId)) {
      card.releasePointerCapture(event.pointerId);
    }
  });
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
