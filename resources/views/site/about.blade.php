@extends('layouts.site')

@section('style')
.ahero{background:linear-gradient(rgba(14,26,20,.6),rgba(14,26,20,.72)),
  url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1800&q=72') center/cover no-repeat;
  color:#fff;padding:76px 0;text-align:center}
.ahero h1{color:#fff}
.ahero p{color:#dde7e1;max-width:640px;margin:0 auto}

.two{display:grid;grid-template-columns:1.15fr 1fr;gap:44px;align-items:center}
.two img{border-radius:var(--radius);width:100%;aspect-ratio:4/3;object-fit:cover}

.steps{counter-reset:s;display:grid;gap:16px}
.step{display:flex;gap:17px;background:#fff;border:1px solid var(--line);border-radius:12px;padding:20px 22px}
.step:before{counter-increment:s;content:counter(s);flex:0 0 36px;width:36px;height:36px;border-radius:50%;
  background:var(--brand);color:#fff;display:grid;place-items:center;font-weight:700;font-size:15px}
.step h3{font-size:17px;margin:0 0 5px}
.step p{margin:0;color:var(--muted);font-size:14.5px}

.note{background:#fffaf0;border:1px solid #f0e0bd;border-left:4px solid var(--gold);
  border-radius:12px;padding:22px 24px;margin-top:26px}
.note h3{margin-bottom:8px}
.note p{margin:0;color:#6b5a37;font-size:15px}

@media(max-width:860px){ .two{grid-template-columns:1fr;gap:26px} }
@endsection

@section('content')
@php $s = config('site'); @endphp

<section class="ahero">
  <div class="wrap">
    <h1>About Sky Property</h1>
    <p>We buy, sell and arrange land in the Morni hills. We live here, and we deal with people who will still be our neighbours next year.</p>
  </div>
</section>

<section class="sec">
  <div class="wrap two">
    <div>
      <h2>Land in the hills is a different business</h2>
      <p>
        In a city, a plot is a rectangle on a map. In Morni it is a slope, a water line,
        an approach road that may or may not take a truck, and a land record that has
        sometimes not been updated in two generations.
      </p>
      <p>
        Most of what goes wrong with a hill purchase is not fraud. It is a buyer who saw a
        beautiful view in March and did not ask what the road looks like in July, or who
        paid for four kanal and later found the khasra says something else.
      </p>
      <p>
        We work in Morni, Tikkar Taal, Bhoj Jabial, Mandana and the belt down to Panchkula
        and Kalka. We walk the ground with you and we tell you the parts that are not in
        the photograph.
      </p>
      <a class="btn btn-primary" href="{{ route('properties') }}">See what is available</a>
    </div>

    <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1000&q=72"
         alt="Morni Hills landscape near Panchkula, Haryana">
  </div>
</section>

<section class="sec sec-soft">
  <div class="wrap">
    <div class="center" style="margin-bottom:34px">
      <h2>How a purchase works with us</h2>
      <p class="lead">Six steps, and you can stop at any of them.</p>
    </div>

    <div class="steps">
      <div class="step">
        <div>
          <h3>Tell us what you want</h3>
          <p>Budget, rough size, and what it is for &mdash; a weekend house, an investment, farming, or a stay to run. That changes which land suits you.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>We shortlist</h3>
          <p>Usually three or four properties. Plenty of what we handle never goes online, so what you see on this site is only part of it.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Site visit</h3>
          <p>We take you there. You see the approach, the slope, the neighbours and the water. No booking amount is asked for at this stage.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Papers</h3>
          <p>Registry, jamabandi, mutation, and the khasra number checked against what is actually on the ground. If something does not match, we say so.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Price</h3>
          <p>Only after the papers. We tell you what similar land has actually sold for nearby, not what the asking prices are.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Registry and after</h3>
          <p>Stamp duty, registration at the tehsil, and the mutation entered in your name. We stay with it until that last part is done.</p>
        </div>
      </div>
    </div>

    <div class="note">
      <h3>One thing we will not do</h3>
      <p>
        We do not sell land with an unclear title, whatever the margin. In the hills a disputed
        plot can sit unusable for years, and the person who has to live with that is you &mdash;
        while we still have to live in the same village.
      </p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap center">
    <h2>Come and see for yourself</h2>
    <p class="lead" style="margin-bottom:24px">
      Call and we will plan a day &mdash; three or four properties, at your pace.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a class="btn btn-primary" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
      <a class="btn btn-ghost" href="{{ route('contact') }}">Send an Enquiry</a>
    </div>
  </div>
</section>
@endsection
