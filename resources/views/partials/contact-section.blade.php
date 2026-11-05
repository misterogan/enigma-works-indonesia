<section class="section" id="kontak" style="{{ $style ?? '' }}">
  <div class="wrap contact">
    <div class="reveal">
      <span class="pill"><b></b>Kontak</span>
      <h2 style="margin-top:18px">{{ $set('contact_title') }}</h2>
      <p>{{ $set('contact_text') }}</p>
      <div class="cinfo">
        <a href="https://wa.me/{{ $set('whatsapp') }}"><i>@include('partials.icon', ['name' => 'pulse'])</i><span><small>WhatsApp dan telepon</small><b>{{ $set('phone') }}</b></span></a>
        <a href="mailto:{{ $set('email') }}"><i>@include('partials.icon', ['name' => 'monitor'])</i><span><small>Email</small><b>{{ $set('email') }}</b></span></a>
        <div><i>@include('partials.icon', ['name' => 'building'])</i><span><small>Kantor</small><b>{{ $set('street') }}, {{ $set('city') }}</b></span></div>
      </div>
    </div>
    @include('partials.contact-form', ['services' => $services])
  </div>
</section>
