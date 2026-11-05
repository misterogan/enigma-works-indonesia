<section class="wrap reveal" aria-label="Ajakan konsultasi" style="margin-top:{{ $top ?? '0' }}">
  <div class="final">
    <small>{{ $set('final_small') }}</small>
    <h2>{{ $title ?? $set('final_title') }}</h2>
    <p>{{ $set('final_text') }}</p>
    <div class="hero-actions">
      <a href="{{ route('contact') }}" class="btn btn-main">Jadwalkan konsultasi</a>
      <a href="https://wa.me/{{ $set('whatsapp') }}" class="btn btn-line">Chat WhatsApp</a>
    </div>
  </div>
</section>
