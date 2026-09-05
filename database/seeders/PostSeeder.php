<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Do shuruaati lekh, taaki blog khaali na khule aur maalik ko dikh jaye
 * ki ek achha post kaisa dikhta hai.
 *
 * Ye sample nahi, sach mein kaam ki jaankari hai -- jo hum kisi bhi
 * kharidaar ko phone par batayenge. Nakli case study ya review isme
 * jaan-boojh kar nahi hai.
 *
 * updateOrCreate slug par chalta hai, isliye dobara chalane par nakal
 * nahi banti.
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title'    => 'How to Check Land Papers Before Buying in Morni Hills',
                'category' => 'legal',
                'cover_image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1400&q=72',
                'cover_alt'   => 'Land record documents being examined before a property purchase',
                'is_featured' => true,
                'excerpt'  => 'Five documents decide whether a piece of Morni land is safe to buy. Here is what each one is, where to get it, and what a problem looks like.',
                'content'  => <<<'HTML'
<p>Almost every bad land purchase in the hills starts the same way: the ground was seen, the price was agreed, and the papers were looked at last. Reverse that order and most of the risk disappears.</p>

<p>Here are the five documents that matter, in the order you should ask for them.</p>

<h2>1. Jamabandi — the record of rights</h2>

<p>This is the main revenue record. It shows who owns the land, how much of it, and in what share. In Haryana you can look it up yourself at <a href="https://jamabandi.nic.in/" target="_blank" rel="noopener nofollow">jamabandi.nic.in</a> using the district, tehsil, village and khasra number.</p>

<p><strong>What to look for:</strong> the seller's name should appear as owner. If the land is in three names, all three have to sign — a common cause of deals collapsing halfway.</p>

<h2>2. Mutation — was the last transfer actually recorded?</h2>

<p>A mutation is the entry that updates the record after a sale or inheritance. People often assume it happened. Frequently it did not.</p>

<p>If the seller inherited the land from a father who died in 2011 and the mutation was never entered, the record still shows the father's name. Nothing can be registered until that is fixed, and fixing it takes months.</p>

<p><strong>Ask directly:</strong> "Is the mutation in your name, and can I see it?" A straight answer here tells you a lot about the rest of the deal.</p>

<h2>3. Khasra number and the map</h2>

<p>The khasra is the plot number in the revenue record, and there is a map that goes with it. Your job is to confirm the paper matches the ground you walked.</p>

<p>This sounds obvious. It is also the single most common mismatch in hill land, because boundaries here follow terraces and stones rather than straight lines, and a terrace can move over fifty years.</p>

<p><strong>Do this:</strong> walk the boundary with the seller, corner to corner, and have them point at each edge. Then compare with the map.</p>

<h2>4. Non-encumbrance certificate</h2>

<p>This says there is no loan or legal charge against the land. It is obtained from the registrar's office and covers a period you specify — thirteen years is usual.</p>

<p>Land with a bank loan against it can still be sold, but the loan has to be cleared and the charge removed first. If nobody mentions a loan and the certificate shows one, you have learned something important.</p>

<h2>5. Land use classification</h2>

<p>Is the land recorded as agricultural or residential? This decides whether you can build.</p>

<p>Agricultural land needs a CLU — change of land use — before a house can legally go up. That takes time, costs money, and is not always granted. If your plan is to build, either buy land already classified residential, or price the conversion honestly into your budget before you commit.</p>

<h2>A short checklist to carry</h2>

<ul>
  <li>Jamabandi seen, seller's name on it</li>
  <li>Mutation entered, not just promised</li>
  <li>Khasra number matches the ground</li>
  <li>Boundaries physically shown, corner to corner</li>
  <li>Non-encumbrance certificate obtained</li>
  <li>Land use classification confirmed</li>
  <li>Every co-owner consents in writing</li>
  <li>A local advocate has read all of it</li>
</ul>

<h2>One thing worth paying for</h2>

<p>Get your own advocate to read the papers. Not the seller's, and not only the agent — us included. It costs a few thousand rupees against a purchase of lakhs, and it is the cheapest insurance in the whole transaction.</p>

<p>We say this knowing it sometimes costs us a sale. A buyer who checks properly is a buyer who does not come back angry two years later.</p>
HTML,
                'faq' => [
                    ['q' => 'Can I check land records in Morni online?', 'a' => 'Yes. Haryana revenue records are public at jamabandi.nic.in. You need the district, tehsil, village and khasra number, all of which the seller should give you without hesitation.'],
                    ['q' => 'What if the mutation is not in the seller\'s name?', 'a' => 'Then the sale cannot be registered until it is corrected. That process runs through the tehsil and takes weeks to months. It is not necessarily fraud, but it is a reason to slow down and not pay a token amount yet.'],
                    ['q' => 'Do I need a lawyer to buy land in Morni?', 'a' => 'You are not legally required to have one, but you should. A local advocate reading the jamabandi, mutation and encumbrance certificate costs a few thousand rupees against a purchase worth lakhs.'],
                    ['q' => 'Can I build a house on agricultural land in Morni?', 'a' => 'Not without a change of land use (CLU). Buy land already classified for residential use if building is the plan, or budget for the conversion before you commit.'],
                ],
                'meta_description' => 'The five documents to check before buying land in Morni Hills — jamabandi, mutation, khasra, non-encumbrance and land use. What each one is and what a problem looks like.',
                'keywords' => 'land papers morni, jamabandi haryana, mutation land record, buying land in morni hills, khasra number check',
            ],
            [
                'title'    => 'Morni Hills or Kasauli? An Honest Comparison for Buyers',
                'category' => 'investment',
                'cover_image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1400&q=72',
                'cover_alt'   => 'View across the Morni Hills near Panchkula, Haryana',
                'is_featured' => true,
                'excerpt'  => 'Both are within two hours of Chandigarh. One is far cheaper and much simpler to buy in. The other resells faster. Which suits you depends on why you are buying.',
                'content'  => <<<'HTML'
<p>Almost everyone who calls us about Morni has also looked at Kasauli, Solan or Parwanoo. That is sensible — they are all within about two hours of Chandigarh. But they are not the same purchase, and the difference is bigger than the price.</p>

<h2>The rule that changes everything</h2>

<p>Kasauli, Solan and Parwanoo are in Himachal Pradesh. Himachal restricts the purchase of land by people who are not Himachali. Buying there as an outsider generally means seeking state permission, and that is a real process with a real chance of refusal.</p>

<p>Morni is in Haryana. There is no such restriction on ordinary plots. Anyone from anywhere in India can buy a residential plot in Morni, and the transaction is a normal registry.</p>

<p>That single fact explains most of the price gap between the two areas.</p>

<h2>Side by side</h2>

<table>
  <thead>
    <tr><th>&nbsp;</th><th>Morni Hills</th><th>Kasauli / Solan</th><th>Parwanoo</th></tr>
  </thead>
  <tbody>
    <tr><th>State</th><td>Haryana</td><td>Himachal Pradesh</td><td>Himachal Pradesh</td></tr>
    <tr><th>From Chandigarh</th><td>1.5 – 2 hours</td><td>1.5 – 2.5 hours</td><td>About 1 hour</td></tr>
    <tr><th>Buying as an outsider</th><td>Straightforward</td><td>Restricted</td><td>Restricted</td></tr>
    <tr><th>Land rates</th><td>Lowest</td><td>Highest</td><td>Middle</td></tr>
    <tr><th>Development</th><td>Still quiet</td><td>Well established</td><td>Industrial edge</td></tr>
    <tr><th>Resale speed</th><td>Slow</td><td>Faster</td><td>Moderate</td></tr>
    <tr><th>Rental demand</th><td>Weekend, seasonal</td><td>Strong, year round</td><td>Weak</td></tr>
  </tbody>
</table>

<h2>What Morni is good for</h2>

<ul>
  <li><strong>A weekend house you will actually use.</strong> Close enough to Chandigarh to drive up on a Saturday morning, cheap enough that the land is not the biggest decision of your life.</li>
  <li><strong>A long hold.</strong> Morni is the only hill station in Haryana and the state has an interest in developing it. That is a slow story, not a two-year one.</li>
  <li><strong>A homestay or small resort.</strong> Weekend traffic from the Tricity is real, and the season runs March to June and again in October.</li>
</ul>

<h2>What Morni is not good for</h2>

<ul>
  <li><strong>Quick resale.</strong> Hill land here moves slowly. If you may need the money back within two or three years, this is the wrong purchase.</li>
  <li><strong>Rental income all year.</strong> The season is real but it is a season. Budget for quiet months.</li>
  <li><strong>Farming as a business.</strong> Terraces are small and most water is seasonal. People do farm here, but few get rich at it.</li>
</ul>

<h2>The honest summary</h2>

<p>If you are buying to use — a house, a stay you will run, land you will hold for ten years — Morni gives you far more for the money and a much simpler purchase.</p>

<p>If you are buying to flip in two years, neither Morni nor Kasauli is a good idea, and Kasauli is only the less bad of the two.</p>

<p>We sell in Morni, so treat this as an interested opinion. But the point about Himachal's rules is a matter of fact, not a sales line, and you should verify it before you decide either way.</p>
HTML,
                'faq' => [
                    ['q' => 'Can a non-Himachali buy land in Kasauli?', 'a' => 'Generally not without permission from the Himachal government, which is a formal process with no guaranteed outcome. Haryana places no such restriction on ordinary plots in Morni, which is the main reason the two markets price so differently.'],
                    ['q' => 'Is Morni cheaper than Kasauli?', 'a' => 'Considerably, and the buying restriction in Himachal is a large part of why. What you give up is liquidity — a Kasauli property finds its next buyer faster.'],
                    ['q' => 'How far is Morni from Chandigarh?', 'a' => 'About 45 km from Panchkula and roughly one and a half to two hours from Chandigarh, depending on where in Morni you are going and the state of the road.'],
                    ['q' => 'Is Morni a good investment?', 'a' => 'For a long hold, or for land you will actually use, it offers more for the money than the Himachal hill stations. For a short-term flip it is not suitable — resale here is slow.'],
                ],
                'meta_description' => 'Morni Hills or Kasauli — which to buy? Himachal restricts land purchase by outsiders while Haryana does not, and that is most of the price gap. An honest comparison.',
                'keywords' => 'morni vs kasauli, buy land morni hills, kasauli land rules, hill property near chandigarh, morni investment',
            ],
        ];

        foreach ($rows as $r) {
            $r['slug']         = Post::uniqueSlug($r['title']);
            $r['status']       = 'published';
            $r['published_at'] = now()->subDays(count($rows) - array_search($r, $rows, true));
            $r['author_name']  = 'Sky Property Morni Hills';
            $r['author_bio']   = 'We buy, sell and arrange land in Morni and around Panchkula, and we live here. Call +91 83073 77270 with anything this article did not answer.';

            Post::updateOrCreate(['slug' => $r['slug']], $r);
        }
    }
}
