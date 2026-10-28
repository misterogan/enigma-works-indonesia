{{-- $faqs: array pasangan [pertanyaan, jawaban]. Isinya sama dengan schema FAQPage. --}}
<div class="faq">
  @foreach ($faqs as [$q, $a])
    <details><summary>{{ $q }}</summary><p>{{ $a }}</p></details>
  @endforeach
</div>
