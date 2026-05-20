// navbar.js – Handles navigation link interactions

document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll('.nav-links a');

  // Smooth scroll for anchor links
  navLinks.forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          const offsetTop = target.offsetTop - 80; // Adjust for sticky header
          window.scrollTo({
            top: offsetTop,
            behavior: 'smooth'
          });
        }
      }
    });
  });

  // Highlight active link based on scroll position
  const sections = Array.from(navLinks).map(link => {
    const href = link.getAttribute('href');
    if (href && href.startsWith('#')) {
      return document.querySelector(href);
    }
    return null;
  }).filter(Boolean);

  const setActiveLink = () => {
    const scrollPos = window.scrollY + 90; // Slight offset for header height
    let current = sections[0];
    for (const sec of sections) {
      if (sec.offsetTop <= scrollPos) {
        current = sec;
      } else {
        break;
      }
    }
    navLinks.forEach(link => {
      link.classList.remove('active');
      const href = link.getAttribute('href');
      if (href === `#${current.id}`) {
        link.classList.add('active');
      }
    });
  };

  window.addEventListener('scroll', setActiveLink);
  // Initial call to set active on load
  setActiveLink();
});
