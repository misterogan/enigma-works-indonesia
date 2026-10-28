<form class="form reveal" id="leadForm" data-whatsapp="{{ $set('whatsapp') }}" data-company="{{ $set('company_name') }}" novalidate>
  <div class="row2">
    <div class="field"><label for="f-nama">Nama</label><input id="f-nama" autocomplete="name" required></div>
    <div class="field"><label for="f-jabatan">Jabatan</label><input id="f-jabatan" placeholder="Direktur, Kepala IT, dll."></div>
  </div>
  <div class="field"><label for="f-instansi">Nama rumah sakit atau klinik</label><input id="f-instansi" autocomplete="organization" required></div>
  <div class="row2">
    <div class="field"><label for="f-kota">Kota</label><input id="f-kota" placeholder="Medan"></div>
    <div class="field"><label for="f-layanan">Kebutuhan</label>
      <select id="f-layanan">
        @foreach ($services as $svc)<option>{{ $svc->name }}</option>@endforeach
        <option>Lainnya</option>
      </select>
    </div>
  </div>
  <div class="field"><label for="f-pesan">Ceritakan singkat kebutuhan Anda</label><textarea id="f-pesan"></textarea></div>
  <p class="form-error" id="formError" role="alert">Mohon isi nama dan nama rumah sakit atau klinik.</p>
  <button type="submit" class="btn btn-grad">Kirim lewat WhatsApp</button>
  <p class="hint">Pesan akan terbuka di WhatsApp dan siap dikirim.</p>
</form>
