@extends('layouts.site', [
    'title'       => 'Contact Sky Property Morni Hills — +91 83073 77270',
    'description' => 'Call or WhatsApp +91 83073 77270 for plots, land and farmhouses in Morni Hills, Panchkula. Free site visits, no booking amount, same-day reply.',
    'keywords'    => 'contact Sky Property Morni Hills, Sky Property Chandigarh, Sky Property Panchkula, property dealer in Morni Hills, property consultant Morni Hills, site visit Morni Hills, buy property in Morni Hills, Morni Hills property enquiry',
])

@section('style')
.chead{background:var(--soft);border-bottom:1px solid var(--line);padding:46px 0 42px;text-align:center}
.cwrap{display:grid;grid-template-columns:1fr 400px;gap:40px;align-items:start;padding:48px 0 66px}
.cinfo{display:grid;gap:16px}
.crow{display:flex;gap:15px;background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px 20px}
.crow .ic{width:44px;height:44px;flex:0 0 44px;border-radius:11px;background:#e9f1e4;
  display:grid;place-items:center;font-size:20px}
.crow h3{font-size:15px;margin:0 0 3px;font-family:Inter,sans-serif;font-weight:700}
.crow p,.crow a{margin:0;color:var(--muted);font-size:15px}
.crow a:hover{color:var(--brand)}

.box{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:26px;box-shadow:var(--shadow)}
.fld{margin-bottom:14px}
.fld label{display:block;font-size:13px;font-weight:600;margin-bottom:5px}
.fld input,.fld textarea,.fld select{width:100%;padding:11px 12px;border:1px solid var(--line);
  border-radius:9px;font-size:15px;font-family:inherit;color:var(--ink);background:#fff}
.fld textarea{min-height:110px;resize:vertical}
.hp{position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden}

.mapbox{border-radius:var(--radius);overflow:hidden;border:1px solid var(--line);margin-top:6px}
.mapbox iframe{display:block;width:100%;height:340px;border:0}

@media(max-width:900px){ .cwrap{grid-template-columns:1fr;gap:30px} }
@endsection

@section('content')
@php $s = config('site'); @endphp

<section class="chead">
  <div class="wrap">
    <h1>Talk to us</h1>
    <p class="lead">Tell us the area and the budget. If we do not have it today, we will find it and call you back.</p>
  </div>
</section>

<div class="wrap cwrap">

  <div>
    <div class="cinfo">
      <div class="crow">
        <div class="ic">📞</div>
        <div>
          <h3>Phone &amp; WhatsApp</h3>
          <a href="tel:{{ $s['phone_link'] }}">{{ $s['phone'] }}</a><br>
          <a href="https://wa.me/{{ $s['whatsapp'] }}" target="_blank" rel="noopener">Message on WhatsApp</a>
        </div>
      </div>

      <div class="crow">
        <div class="ic">📍</div>
        <div>
          <h3>Office</h3>
          <p>{{ $s['address_line'] }}</p>
        </div>
      </div>

      <div class="crow">
        <div class="ic">✉</div>
        <div>
          <h3>Email</h3>
          <a href="mailto:{{ $s['email'] }}">{{ $s['email'] }}</a>
        </div>
      </div>

      <div class="crow">
        <div class="ic">🕘</div>
        <div>
          <h3>Open</h3>
          <p>{{ $s['hours'] }}</p>
        </div>
      </div>
    </div>

    <h2 style="margin:34px 0 12px;font-size:22px">Find us</h2>
    <div class="mapbox">
      <iframe title="Sky Property Morni Hills location on map" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps?q=Morni,+Panchkula,+Haryana+134205&output=embed"></iframe>
    </div>
  </div>

  <aside>
    <div class="box">
      <h2 style="font-size:21px;margin-bottom:5px">Send an enquiry</h2>
      <p style="color:var(--muted);font-size:14px;margin-bottom:18px">We reply the same day, usually within an hour.</p>

      @if(session('ok'))
        <div class="alert alert-ok">{{ session('ok') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-err">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('enquiry') }}">
        @csrf
        <input type="hidden" name="source_page" value="{{ url()->current() }}">

        <div class="hp" aria-hidden="true">
          <label for="cWebsite">Website</label>
          <input type="text" id="cWebsite" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="fld">
          <label for="cName">Your name</label>
          <input type="text" id="cName" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="fld">
          <label for="cPhone">Phone number</label>
          <input type="tel" id="cPhone" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div class="fld">
          <label for="cEmail">Email <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
          <input type="email" id="cEmail" name="email" value="{{ old('email') }}">
        </div>

        <div class="fld">
          <label for="cBudget">Budget</label>
          <select id="cBudget" name="budget">
            <option value="">Not decided yet</option>
            <option value="Under ₹10 Lakh">Under ₹10 Lakh</option>
            <option value="₹10–25 Lakh">₹10 – 25 Lakh</option>
            <option value="₹25–50 Lakh">₹25 – 50 Lakh</option>
            <option value="₹50 Lakh – 1 Crore">₹50 Lakh – 1 Crore</option>
            <option value="Above ₹1 Crore">Above ₹1 Crore</option>
          </select>
        </div>

        <div class="fld">
          <label for="cMsg">What are you looking for?</label>
          <textarea id="cMsg" name="message" placeholder="Plot in Morni, around 4 kanal, road touch…">{{ old('message') }}</textarea>
        </div>

        <button class="btn btn-primary btn-block" type="submit">Send Enquiry</button>
      </form>
    </div>
  </aside>
</div>

<section class="sec sec-soft">
  <div class="wrap" style="max-width:880px">
    @include('site.partials.faq', [
        'faqTitle' => 'Before You Call',
        'faqs' => [
            ['q' => 'What should I have ready when I call?', 'a' => 'A rough budget, the kind of property, and what it is for &mdash; a weekend house, an investment, an orchard or a stay to run. Those four lead to very different land, so the purpose helps more than the budget alone.'],
            ['q' => 'How quickly do you reply?', 'a' => 'Same day, usually within the hour during working hours. If you send an enquiry at night, expect a call the next morning.'],
            ['q' => 'How soon can I visit?', 'a' => 'Usually within a day or two. Call ahead so a route can be planned &mdash; we will line up three or four properties for one trip, which teaches you more than any description.'],
            ['q' => 'Is there any charge to visit?', 'a' => 'None. No visit fee, no booking amount, no obligation. Nobody should be asking you for money before you have seen the papers.'],
            ['q' => 'Where exactly are you?', 'a' => 'Morni, Panchkula, Haryana 134205 &mdash; about 45 km from Panchkula and an hour and a half to two hours from Chandigarh, depending on the road.'],
            ['q' => 'What are your hours?', 'a' => 'Monday to Sunday, 9 AM to 7 PM. Morning visits are better, especially in the monsoon when the road slows everything down.'],
            ['q' => 'Can I message on WhatsApp instead?', 'a' => 'Yes, on the same number: +91 83073 77270. It is often easier for sending photographs or a khasra number.'],
            ['q' => 'I want to sell my property in Morni. Can you help?', 'a' => 'Yes. Send the khasra number and whatever papers you have, and we will tell you honestly what it is likely to fetch and roughly how long it may take.'],
            ['q' => 'Do you deal outside Morni?', 'a' => 'Yes &mdash; Tikkar Taal, Bhoj Jabial, Mandana, Thandog and Baldwala in the hills, and Panchkula, Pinjore, Kalka and Raipur Rani below them.'],
            ['q' => 'What if you do not have what I want?', 'a' => 'We will say so, and call you when it comes up. A good deal of what we handle never reaches the website, so it is always worth asking.'],
        ],
    ])
  </div>
</section>
@endsection
