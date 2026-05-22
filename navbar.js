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
/* -------------------------------------------------
   Lava‑Rápido F1 – Navbar (gerado via JavaScript)
   ------------------------------------------------- */
(() => {
  // ----- Configurações -----
  const MENU_ITEMS = [
    { href: "#home",      label: "Home",     active: true },
    { href: "#services",  label: "Serviços" },
    { href: "#pricing",   label: "Preços" },
    { href: "#about",     label: "Sobre" },
    { href: "#contact",   label: "Contato" }
  ];
  const PRIMARY_COLOR = "#007BFF";   // mesma cor usada no resto do site
  // ----- Cria a estrutura do header -----
  const header = document.createElement("header");
  header.className = "navbar";
  // LOGO / marca (pode ser trocada por <img> depois)
  const logo = document.createElement("a");
  logo.href = "#home";
  logo.className = "navbar-brand";
  logo.textContent = "Lava‑Rápido F1";
  header.appendChild(logo);
  // NAV (lista de links)
  const nav = document.createElement("nav");
  nav.className = "nav-links";
  MENU_ITEMS.forEach(item => {
    const a = document.createElement("a");
    a.href = item.href;
    a.textContent = item.label;
    if (item.active) a.classList.add("active");
    nav.appendChild(a);
  });
  header.appendChild(nav);
  // ÍCONE “hamburger” (visível só em telas pequenas)
  const toggle = document.createElement("a");
  toggle.href = "javascript:void(0);";
  toggle.className = "nav-toggle";
  toggle.setAttribute("aria-label", "Abrir menu");
  toggle.innerHTML = '<i class="fa fa-bars"></i>';
  header.appendChild(toggle);
  // Insere o header no <body> (no início)
  document.body.insertBefore(header, document.body.firstChild);
  // ----- Função de abrir/fechar -----
  const toggleNav = () => header.classList.toggle("responsive");
  toggle.addEventListener("click", toggleNav);
  // Opcional: fechar o menu ao clicar em um link (melhor UX mobile)
  nav.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => {
      if (header.classList.contains("responsive")) header.classList.remove("responsive");
    });
  });
  // ----- Estilo rápido (fallback caso o CSS ainda não tenha sido carregado) -----
  const style = document.createElement("style");
  style.textContent = `
    /* Garantia mínima caso style.css ainda não esteja incluído */
    .navbar { 
      position:sticky; top:0; z-index:1000; 
      display:flex; align-items:center; justify-content:space-between;
      padding:.8rem 1.5rem; 
      background:rgba(0,123,255,.15); backdrop-filter:blur(12px);
      border-bottom:1px solid rgba(255,255,255,.2);
      box-shadow:0 4px 12px rgba(0,0,0,.15);
      transition:background .3s,box-shadow .3s;
    }
    .navbar-brand {font-family:'Inter',Arial,sans-serif;font-size:1.4rem;font-weight:600;color:${PRIMARY_COLOR};text-decoration:none;}
    .nav-links a {color:#fff;margin-left:1.5rem;text-decoration:none;position:relative;transition:color .2s,transform .2s;}
    .nav-links a.active {color:${PRIMARY_COLOR};}
    .nav-links a:hover {color:${PRIMARY_COLOR};transform:translateY(-2px);}
    .nav-toggle {display:none;font-size:1.8rem;color:#fff;cursor:pointer;}
    @media screen and (max-width:768px){
      .nav-links{position:absolute;top:100%;left:0;right:0;background:rgba(0,123,255,.15);
                flex-direction:column;max-height:0;overflow:hidden;transition:max-height .4s ease-out;}
      .navbar.responsive .nav-links{max-height:400px;padding:.8rem 1.5rem;}
      .nav-links a{margin:.6rem 0;width:100%;}
      .nav-toggle{display:block;}
    }
  `;
  document.head.appendChild(style);
})();