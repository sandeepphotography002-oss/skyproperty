{{-- Dobara istemaal hone wala FAQ hissa.
     $faqs  — [['q' => …, 'a' => …], …]
     $faqTitle — heading (marzi se)

     Schema aur dikhne wale sawaal dono isi ek array se bante hain.
     Alag-alag likhte to ek din wo alag ho jaate, aur Google ko wo
     dikhta jo page par hai hi nahi -- uspar manual action milta hai. --}}
@php $faqs = array_values(array_filter($faqs ?? [], fn ($f) => filled($f['q'] ?? null) && filled($f['a'] ?? null))); @endphp

@if($faqs)
<script type="application/ld+json">
{!! json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($f) => [
        '@type'          => 'Question',
        'name'           => $f['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f['a'])],
    ], $faqs),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<div class="faqbox">
  <h2>{{ $faqTitle ?? 'Questions People Ask' }}</h2>

  @foreach($faqs as $f)
    <details class="fq">
      <summary><span class="fq-plus">+</span><span>{{ $f['q'] }}</span></summary>
      <div class="fq-a">{!! $f['a'] !!}</div>
    </details>
  @endforeach
</div>
@endif
