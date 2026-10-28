// Interaksi website Enigma Works Indonesia
const $ = (s, el = document) => el.querySelector(s);
const $$ = (s, el = document) => Array.from(el.querySelectorAll(s));
const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Tinggi bar pengumuman + header, agar banner pas satu layar
const header = $('#siteHeader');
const bar = $('.announce');
const setChrome = () => {
  if (!header) return;
  document.documentElement.style.setProperty('--chrome', ((bar ? bar.offsetHeight : 0) + header.offsetHeight) + 'px');
};
setChrome();
window.addEventListener('resize', setChrome);

// Header blur saat di-scroll
const onScroll = () => header && header.classList.toggle('scrolled', window.scrollY > 8);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

// Menu mobile
const toggle = $('#menuToggle');
const links = $('#navLinks');
if (toggle && links) {
  toggle.addEventListener('click', () => {
    const open = links.classList.toggle('open');
    toggle.setAttribute('aria-expanded', open);
    toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
  });
  $$('a', links).forEach((a) => a.addEventListener('click', () => {
    links.classList.remove('open');
    toggle.setAttribute('aria-expanded', 'false');
  }));
}

// Animasi muncul saat di-scroll (konten tetap tampil bila JS gagal)
const reveals = $$('.reveal');
if ('IntersectionObserver' in window && !reduce) {
  document.documentElement.classList.add('reveal-on');
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      const sibs = Array.from(e.target.parentElement.children).filter((n) => n.classList.contains('reveal'));
      e.target.style.transitionDelay = Math.min(sibs.indexOf(e.target), 5) * 80 + 'ms';
      e.target.classList.add('in');
      io.unobserve(e.target);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  reveals.forEach((el) => io.observe(el));
}

// Angka menghitung naik
if (!reduce && 'IntersectionObserver' in window) {
  $$('[data-count]').forEach((el) => {
    const target = +el.dataset.count;
    const suffix = el.dataset.suffix || '';
    const o = new IntersectionObserver((entries) => {
      if (!entries[0].isIntersecting) return;
      o.disconnect();
      let start = null;
      const step = (t) => {
        if (!start) start = t;
        const p = Math.min((t - start) / 1400, 1);
        el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))).toLocaleString('id-ID') + suffix;
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    }, { threshold: 0.6 });
    o.observe(el);
  });
}

// Tombol geser portofolio
const rail = $('#rail');
$$('.rail-btns button').forEach((b) => b.addEventListener('click', () => {
  if (rail) rail.scrollBy({ left: (+b.dataset.dir) * 380, behavior: reduce ? 'auto' : 'smooth' });
}));

// Hentikan animasi banner untuk pengguna "kurangi gerakan"
const art = $('#bannerArt');
if (reduce && art && art.pauseAnimations) art.pauseAnimations();

// Formulir konsultasi: membuka WhatsApp dengan pesan terisi
const form = $('#leadForm');
if (form) {
  const err = $('#formError');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const v = (id) => (document.getElementById(id)?.value || '').trim();
    if (!v('f-nama') || !v('f-instansi')) { err.style.display = 'block'; return; }
    err.style.display = 'none';
    const msg = `Halo ${form.dataset.company}, saya ingin konsultasi.\n\n` +
      `Nama: ${v('f-nama')}\nJabatan: ${v('f-jabatan') || '-'}\nInstansi: ${v('f-instansi')}\n` +
      `Kota: ${v('f-kota') || '-'}\nKebutuhan: ${v('f-layanan')}\nPesan: ${v('f-pesan') || '-'}`;
    window.open('https://wa.me/' + form.dataset.whatsapp + '?text=' + encodeURIComponent(msg), '_blank', 'noopener');
  });
}

// Bar loading saat berpindah halaman (halaman tetap dimuat penuh oleh server, aman untuk SEO)
const showLoader = () => document.documentElement.classList.add('is-loading');
const hideLoader = () => document.documentElement.classList.remove('is-loading');
let loaderTimer;
document.addEventListener('click', (e) => {
  const a = e.target.closest('a[href]');
  if (!a || e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
  if ((a.target && a.target !== '_self') || a.hasAttribute('download')) return;
  const url = new URL(a.href, location.href);
  if (url.origin !== location.origin) return;
  // Link ke bagian di halaman yang sama (#kontak, dll.) tidak memuat ulang halaman
  if (url.pathname === location.pathname && url.search === location.search && url.hash) return;
  // Tunda sedikit agar bar tidak berkedip bila halaman sudah di-prefetch dan langsung terbuka
  clearTimeout(loaderTimer);
  loaderTimer = setTimeout(showLoader, 120);
});
// Kembali lewat tombol Back (bfcache): sembunyikan bar
window.addEventListener('pageshow', () => { clearTimeout(loaderTimer); hideLoader(); });
