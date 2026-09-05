{{-- Homepage ka lamba hissa: guide, price table, process, checklist,
     comparison aur FAQ. Alag file mein isliye ki home.blade.php pehle
     hi bada hai, aur ye content aage badalta rahega. --}}
@php
    $s = config('site');

    /* Ek hi jagah likhe hue sawaal-jawab. Neeche accordion inhi se
       banta hai aur upar FAQPage schema bhi -- taaki Google ko kuch
       aur na dikhe aur padhne wale ko kuch aur. */
    $faqs = [
        [
            'q' => 'Is Morni Hills a good place to buy land?',
            'a' => 'For a weekend house or a long-hold investment, yes. Morni is the only hill station in Haryana, it is about 45 kilometres from Panchkula and under two hours from Chandigarh, and rates are still far below Kasauli or Solan. For farming income it is harder — the terraces are small and water is seasonal. What you should not expect is a quick resale; hill land moves slowly.',
        ],
        [
            'q' => 'Can anyone buy land in Morni, or only Haryana residents?',
            'a' => 'Residential and commercial plots in Morni can be bought by any Indian citizen, whatever state you are from. Agricultural land is the one to be careful with — rules on who may buy farm land differ from ordinary plots, and the answer depends on the land classification in the revenue record. Ask us for the khasra and jamabandi before you decide, and have a local advocate read it.',
        ],
        [
            'q' => 'What documents should I check before buying?',
            'a' => 'Five, in this order: the <strong>jamabandi</strong> (record of rights, showing who owns it), the <strong>mutation</strong> (that the last transfer was actually entered), the <strong>khasra number and map</strong> (that the paper matches the ground you stood on), a <strong>non-encumbrance certificate</strong> (no loan against it), and the <strong>land use classification</strong> (whether it is residential or agricultural). If any one of these is missing, wait.',
        ],
        [
            'q' => 'How much does land cost in Morni Hills?',
            'a' => 'It depends far more on the approach road than on the view. The same size of plot can differ several times over between a road-touch piece and one that needs a walk in. The table above shows the actual range across the listings on this site right now, which is a more honest guide than a fixed rate card.',
        ],
        [
            'q' => 'Is there a road to every plot?',
            'a' => 'No, and this is the single most common thing buyers miss. Plenty of beautiful land in Morni has only a footpath. That matters because building material has to reach the site — if a tractor cannot get there, construction costs rise sharply. We tell you the approach for every property, and we will walk it with you.',
        ],
        [
            'q' => 'Is water and electricity available?',
            'a' => 'Electricity reaches most inhabited parts of Morni, though the pole may be some distance from a particular plot and the connection is at your cost. Water is the harder question. Some plots have a village line, some depend on a borewell, and some on a seasonal channel that is dry from January to June. Always ask which of the three, and see the site in summer if you can.',
        ],
        [
            'q' => 'Can I build a house on agricultural land in Morni?',
            'a' => 'Not directly. Agricultural land has to be converted through a CLU — change of land use — before a house can legally be built on it. That takes time and money and is not always granted. If your plan is to build, buy land already classified for residential use, or budget honestly for the conversion before you commit.',
        ],
        [
            'q' => 'What is the registry cost and stamp duty?',
            'a' => 'Stamp duty and registration charges in Haryana are set by the state and depend on the collector rate for that area, whether the buyer is a man or a woman, and whether the property is rural or urban. They are paid on top of the sale price. Get the exact figure from the tehsil for your specific plot before you plan the money — a percentage quoted in a conversation is not a substitute.',
        ],
        [
            'q' => 'How long does the whole purchase take?',
            'a' => 'Usually three to six weeks from agreement to registry, if the papers are clean. Most of the time goes into checking records and arranging the registry appointment. If a mutation is pending or the ownership is split between family members, it takes longer — and that is a reason to slow down, not to hurry.',
        ],
        [
            'q' => 'Do you charge for a site visit?',
            'a' => 'No. Come and see three or four properties in a day, at your own pace. There is no booking amount, no signature and no obligation at that stage. Call ' . $s['phone'] . ' a day or two ahead so we can plan the route.',
        ],
        [
            'q' => 'Can I get a home loan on land in Morni?',
            'a' => 'Loans against plots are harder than loans against built houses, and hill land harder still. Banks look closely at the title, the approach and the resale market. Some do lend on residential plots with clear registry. Speak to your bank early — before you commit — rather than assuming the loan will follow.',
        ],
        [
            'q' => 'Is a resort or homestay in Morni a good business?',
            'a' => 'It can be, and Morni does get steady weekend traffic from Chandigarh and Panchkula, with the season strongest from March to June and again in October. But it is a business, not passive income — staff, licences, maintenance and off-season months are all real. Buy a running one and look at its books, or budget for two slow years while you build the business.',
        ],
    ];
@endphp

{{-- FAQPage schema. Sawaal wahi jo neeche dikh rahe hain -- Google ko
     aisa kuch bhejna jo page par na ho, policy ke khilaaf hai. --}}
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

<section class="sec" id="guide">
  <div class="wrap gd">

    <h2>Buying Property in Morni Hills — What You Should Know</h2>

    <p class="gd-answer">
      <strong>Short answer:</strong> Morni Hills is the only hill station in Haryana, about
      45&nbsp;km from Panchkula and under two hours from Chandigarh. You can buy residential
      plots, farm land, built farmhouses, cottages, and running resorts or homestays here.
      Rates are still well below Kasauli and Solan. The two things that decide whether a
      piece of Morni land is worth its price are the <strong>approach road</strong> and the
      <strong>papers</strong> &mdash; not the view. Call
      <a href="tel:{{ $s['phone_link'] }}">{{ $s['phone'] }}</a> and we will walk the ground with you.
    </p>

    <p>
      Most people who come to us have seen a photograph and fallen for it. That is a fine
      way to start, and a bad way to finish. A slope that looks gentle in a picture may need
      three retaining walls. A plot that is ten minutes from the road in December may be
      cut off after two days of July rain. None of that is dishonesty on anyone's part
      &mdash; it is simply what a photograph cannot show.
    </p>

    <p>
      This page is what we would tell you sitting in the office, written down. If something
      here does not match what you are being told elsewhere, ask us why. We would rather
      argue about it now than after a registry.
    </p>

    {{-- ── types ── --}}
    <h2>What Kind of Property Can You Buy in Morni?</h2>

    <p>Six kinds, and they suit very different plans:</p>

    <ul class="gd-list">
      <li><strong>Residential plots</strong> &mdash; usually 5 to 20 marla, inside or near a village. Best if you want to build your own weekend house and want the paperwork simple.</li>
      <li><strong>Agricultural land</strong> &mdash; sold in kanal and acre, often terraced. Cheaper per unit area, but you cannot build on it without a change of land use.</li>
      <li><strong>Farmhouses</strong> &mdash; built houses on larger land, often with an orchard. You pay for someone else's construction, but you also see what nine monsoons did to the roof.</li>
      <li><strong>Hill cottages</strong> &mdash; smaller built homes, frequently in stone and timber. Ready to move into, good for weekend use.</li>
      <li><strong>Resorts</strong> &mdash; running businesses with rooms, kitchen and licences. Sold as a going concern, price reflects the business, not just the land.</li>
      <li><strong>Homestays</strong> &mdash; smaller stays, often with an owner's portion, registered under the Haryana homestay scheme.</li>
    </ul>

    {{-- ── price ── --}}
    <h2>How Much Does Property in Morni Hills Cost?</h2>

    <p>
      There is no single rate for Morni, and anyone who gives you one has not seen your plot.
      Two pieces of land a hundred metres apart can differ several times over in price because
      one has a road to it and the other has a footpath.
    </p>

    @if($priceGuide->isNotEmpty())
      <p>
        Rather than quote a rate card that goes stale, here is the actual range across the
        listings on this site today, updated the moment a property is added or sold:
      </p>

      <div class="gd-tbl">
        <table>
          <thead>
            <tr><th>Property type</th><th>Listings</th><th>Range on this site</th></tr>
          </thead>
          <tbody>
            @foreach($priceGuide as $g)
              @php
                $money = function ($n) {
                    $n = (int) $n;
                    if ($n >= 10000000) return '₹' . rtrim(rtrim(number_format($n / 10000000, 2), '0'), '.') . ' Cr';
                    if ($n >= 100000)   return '₹' . rtrim(rtrim(number_format($n / 100000, 2), '0'), '.') . ' Lakh';
                    return '₹' . number_format($n);
                };
              @endphp
              <tr>
                <td>{{ \App\Models\Property::TYPES[$g->type] ?? ucfirst($g->type) }}</td>
                <td>{{ $g->n }}</td>
                <td>{{ $g->lo == $g->hi ? $money($g->lo) : $money($g->lo) . ' – ' . $money($g->hi) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <p class="gd-note">
        These are asking prices on current listings, not a valuation of Morni as a whole.
        For what a specific plot is actually worth, call us with its khasra number.
      </p>
    @endif

    <h3>What Actually Moves the Price</h3>

    <ul class="gd-list">
      <li><strong>Approach road</strong> &mdash; the biggest single factor. Road-touch land commands a large premium, and rightly so: building material has to reach the site.</li>
      <li><strong>Water</strong> &mdash; a village line or a working borewell is worth far more than a seasonal channel.</li>
      <li><strong>Slope</strong> &mdash; gentle ground needs one retaining wall; a cut face may need three, and that cost is yours.</li>
      <li><strong>Classification</strong> &mdash; residential land costs more than agricultural, because you can build on it without a conversion.</li>
      <li><strong>Distance from the Morni road</strong> &mdash; every kilometre inward reduces the price and increases what you will spend getting there.</li>
      <li><strong>Clean title</strong> &mdash; land with a disputed or split ownership sells cheap for a reason.</li>
    </ul>

    {{-- ── process ── --}}
    <h2>How Does Buying Work, Step by Step?</h2>

    <div class="gd-steps">
      <div class="gd-step"><b>1</b><div><strong>Tell us the plan</strong><p>Budget, rough size, and what it is for. A weekend house, an investment and a homestay need three different kinds of land.</p></div></div>
      <div class="gd-step"><b>2</b><div><strong>We shortlist</strong><p>Three or four properties. A good deal of what we handle never reaches this website, so ask even if nothing here fits.</p></div></div>
      <div class="gd-step"><b>3</b><div><strong>Site visit</strong><p>You walk the ground, see the approach and meet the neighbours. No booking amount is asked for at this stage.</p></div></div>
      <div class="gd-step"><b>4</b><div><strong>Papers</strong><p>Jamabandi, mutation, khasra map, non-encumbrance. We put them in front of you before we talk about price.</p></div></div>
      <div class="gd-step"><b>5</b><div><strong>Price and agreement</strong><p>We tell you what similar land nearby actually sold for, not what people are asking. Then a written agreement.</p></div></div>
      <div class="gd-step"><b>6</b><div><strong>Registry and mutation</strong><p>Stamp duty, registration at the tehsil, and the mutation entered in your name. We stay with it until that last entry is done.</p></div></div>
    </div>

    {{-- ── checklist ── --}}
    <h2>Checklist: What to Verify Before You Pay Anything</h2>

    <p>Take this with you on the site visit. If you cannot tick a line, do not pay a token amount.</p>

    <ul class="gd-check">
      <li>Jamabandi seen, and the seller's name is on it</li>
      <li>Last mutation actually entered, not merely promised</li>
      <li>Khasra number matches the ground you walked</li>
      <li>Boundaries physically shown by the seller, corner to corner</li>
      <li>Land use classification confirmed &mdash; residential or agricultural</li>
      <li>Non-encumbrance certificate obtained, no loan against the land</li>
      <li>Approach road seen with your own eyes, all the way in</li>
      <li>Water source identified, and whether it runs in summer</li>
      <li>Distance to the nearest electricity pole known</li>
      <li>If multiple owners, every one of them consents in writing</li>
      <li>Stamp duty and registration cost confirmed at the tehsil</li>
      <li>Local advocate has read the papers &mdash; not only the agent</li>
    </ul>

    <p class="gd-note">
      You can verify land records yourself. Haryana's revenue records are public at
      <a href="https://jamabandi.nic.in/" target="_blank" rel="noopener nofollow">jamabandi.nic.in</a>,
      and district information is at
      <a href="https://panchkula.gov.in/" target="_blank" rel="noopener nofollow">panchkula.gov.in</a>.
      We encourage it. A buyer who has read the record asks better questions.
    </p>

    {{-- ── comparison ── --}}
    <h2>Morni or Somewhere Else? An Honest Comparison</h2>

    <p>
      People looking at Morni are usually also looking at Kasauli, Solan or Parwanoo. They are
      not the same purchase:
    </p>

    <div class="gd-tbl">
      <table>
        <thead>
          <tr><th>&nbsp;</th><th>Morni Hills</th><th>Kasauli / Solan</th><th>Parwanoo</th></tr>
        </thead>
        <tbody>
          <tr><th>State</th><td>Haryana</td><td>Himachal Pradesh</td><td>Himachal Pradesh</td></tr>
          <tr><th>From Chandigarh</th><td>~1.5–2 hours</td><td>~1.5–2.5 hours</td><td>~1 hour</td></tr>
          <tr><th>Land rates</th><td>Lowest of the three</td><td>Highest</td><td>Middle</td></tr>
          <tr><th>Buying rules for outsiders</th><td>Straightforward for plots</td><td>Restricted for non-Himachalis</td><td>Restricted for non-Himachalis</td></tr>
          <tr><th>Crowd</th><td>Quiet, still developing</td><td>Busy, well established</td><td>Industrial edge</td></tr>
          <tr><th>Resale speed</th><td>Slow</td><td>Faster</td><td>Moderate</td></tr>
        </tbody>
      </table>
    </div>

    <p>
      The honest summary: Morni is cheaper and much simpler to buy in, because Himachal
      restricts land purchase by people from outside the state while Haryana does not. What
      you give up is liquidity &mdash; a Kasauli property finds a buyer faster. If you are
      buying to use, Morni is the better value. If you are buying to flip in two years,
      neither is a good idea.
    </p>

    {{-- ── who we are ── --}}
    <h2>Who You Are Dealing With</h2>

    <p>
      <strong>{{ $s['name'] }}</strong> is based in Morni itself, not in a Chandigarh office
      that visits on weekends. That matters in a small place: we sell to people who will be
      our neighbours, and we still have to live here after the deal is done. It is the main
      reason we turn down land with an unclear title, whatever the margin on it would be.
    </p>

    <ul class="gd-list">
      <li><strong>Where we work:</strong> {{ implode(', ', $s['areas']) }}</li>
      <li><strong>Office:</strong> {{ $s['address_line'] }}</li>
      <li><strong>Phone and WhatsApp:</strong> <a href="tel:{{ $s['phone_link'] }}">{{ $s['phone'] }}</a></li>
      <li><strong>Open:</strong> {{ $s['hours'] }}</li>
      <li><strong>Site visits:</strong> free, no booking amount, no obligation</li>
    </ul>

    {{-- ── faq ── --}}
    <h2 id="faq">Questions People Ask Us</h2>

    <div class="gd-faq">
      @foreach($faqs as $f)
        <details class="gd-q">
          <summary><span class="gd-plus">+</span><span>{{ $f['q'] }}</span></summary>
          <div class="gd-a">{!! $f['a'] !!}</div>
        </details>
      @endforeach
    </div>

    <div class="gd-cta">
      <div>
        <h3>Still deciding?</h3>
        <p>Call and describe what you want. If we do not have it, we will say so &mdash; and call you when it comes up.</p>
      </div>
      <div style="display:flex;gap:11px;flex-wrap:wrap">
        <a class="btn btn-primary" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
        <a class="btn btn-ghost" href="{{ route('properties') }}">Browse Properties</a>
      </div>
    </div>

    <p class="gd-updated">
      Written by the {{ $s['name'] }} team in Morni ·
      Last updated {{ now()->format('F Y') }} ·
      General guidance only &mdash; confirm land records and current charges at the tehsil
      before you commit to a purchase.
    </p>

  </div>
</section>
