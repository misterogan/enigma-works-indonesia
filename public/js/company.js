// Interaksi company profile PT Enigma Works Indonesia (terpisah dari Enigma Health)
const $ = (s, el = document) => el.querySelector(s);
const $$ = (s, el = document) => Array.from(el.querySelectorAll(s));
const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Garis bawah navigasi saat di-scroll
const nav = $('#nav');
const onScroll = () => nav && nav.classList.toggle('scrolled', window.scrollY > 8);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

// Menu hamburger
const toggle = $('#menuToggle');
const links = $('#navLinks');
const setMenu = (open) => {
  links.classList.toggle('open', open);
  toggle.setAttribute('aria-expanded', String(open));
  toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
};
if (toggle && links) {
  toggle.addEventListener('click', () => setMenu(!links.classList.contains('open')));
  $$('a', links).forEach((a) => a.addEventListener('click', () => setMenu(false)));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false); });
}

// Tandai tautan navigasi untuk bagian yang sedang dilihat
if ('IntersectionObserver' in window) {
  const navLinks = $$('a', links || document.createElement('ul'));
  const spy = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      navLinks.forEach((a) => a.classList.toggle('active', a.getAttribute('href') === '#' + e.target.id));
    });
  }, { rootMargin: '-45% 0px -50% 0px' });
  navLinks.forEach((a) => { const s = $(a.getAttribute('href')); if (s) spy.observe(s); });
}

// Animasi muncul saat di-scroll; tanpa JS atau dengan "kurangi gerakan", konten langsung tampil
if ('IntersectionObserver' in window && !reduce) {
  document.documentElement.classList.add('js-reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      const sibs = Array.from(e.target.parentElement.children).filter((n) => n.classList.contains('reveal'));
      e.target.style.transitionDelay = Math.min(sibs.indexOf(e.target), 5) * 70 + 'ms';
      e.target.classList.add('in');
      io.unobserve(e.target);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  $$('.reveal').forEach((el) => io.observe(el));
}

// Hentikan animasi SVG sirkuit untuk pengguna "kurangi gerakan"
const art = $('#circuitArt');
if (reduce && art && art.pauseAnimations) art.pauseAnimations();

// Formulir: membuka WhatsApp dengan pesan terisi
const form = $('#contactForm');
if (form) {
  const err = $('#formError');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const v = (id) => (document.getElementById(id)?.value || '').trim();
    if (!v('c-nama') || !v('c-perusahaan')) { err.hidden = false; return; }
    err.hidden = true;
    const msg = `Halo ${form.dataset.company}, saya ingin konsultasi.\n\n` +
      `Nama: ${v('c-nama')}\nPerusahaan: ${v('c-perusahaan')}\n` +
      `Kebutuhan: ${v('c-kebutuhan')}\nPesan: ${v('c-pesan') || '-'}`;
    window.open('https://wa.me/' + form.dataset.whatsapp + '?text=' + encodeURIComponent(msg), '_blank', 'noopener');
  });
}
