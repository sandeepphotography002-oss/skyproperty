<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Shuruaati listings, taaki site khaali na khule.
 *
 * Ye asli property nahi hain -- daam aur jagah Morni ke aas-paas ke
 * hisaab se rakhe gaye hain taaki site sach jaisi dikhe. Maalik inhe
 * admin se badal ya delete kar sakta hai.
 *
 * updateOrCreate slug par chalta hai, isliye dobara chalane par nakal
 * nahi banti.
 */
class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $hill  = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1400&q=72';
        $land  = 'https://images.unsplash.com/photo-1444858291040-58f756a3bdd6?w=1400&q=72';
        $house = 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1400&q=72';
        $cot   = 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=1400&q=72';
        $res   = 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=1400&q=72';
        $stay  = 'https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?w=1400&q=72';
        $view  = 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1400&q=72';

        $rows = [
            [
                'title' => '4 Kanal Plot with Valley View in Morni',
                'type' => 'plot', 'listing' => 'sale',
                'price' => 4800000, 'area' => 4, 'area_unit' => 'kanal',
                'locality' => 'Morni', 'ownership' => 'Freehold', 'facing' => 'South-East',
                'approach_road' => '18 ft tar road',
                'is_featured' => true, 'sort_order' => 1,
                'cover_image' => $hill, 'images' => [$hill, $view, $land],
                'short_description' => 'Open plot on a gentle slope above the Morni road, with the valley in full view to the south-east.',
                'description' => "The plot sits about three kilometres above the main Morni market, on the right side of the road going up towards Tikkar Taal.\n\nThe ground is a gentle slope rather than a cut face, so a house can be built with one retaining wall instead of three. Electricity poles run along the road at the boundary. A water connection is available from the village line.\n\nRegistry is clear and in one name. The khasra matches the ground; we have walked the boundary with the seller.",
                'features' => ['Road touch — 18 ft tar road', 'Electricity pole at boundary', 'Village water line available', 'Valley view, south-east facing', 'Gentle slope, easy to build on', 'Clear registry, single owner'],
            ],
            [
                'title' => '3 BHK Farmhouse on 2 Acre near Tikkar Taal',
                'type' => 'farmhouse', 'listing' => 'sale',
                'price' => 21500000, 'area' => 2, 'area_unit' => 'acre',
                'bedrooms' => 3, 'bathrooms' => 3,
                'locality' => 'Tikkar Taal', 'ownership' => 'Freehold', 'facing' => 'North',
                'approach_road' => 'Private approach, 12 ft',
                'is_featured' => true, 'sort_order' => 2,
                'cover_image' => $house, 'images' => [$house, $view, $cot],
                'short_description' => 'A built farmhouse on two acres, ten minutes from the Tikkar lake, with fruit trees already grown.',
                'description' => "Built in 2016 and lived in since, so nothing here is untested — the roof has been through nine monsoons.\n\nThree bedrooms with attached baths, a large front verandah facing north over the orchard, and a separate two-room staff quarter at the back. Borewell on site with a storage tank. Solar water heater installed.\n\nRoughly sixty fruit trees — mango, litchi, guava and plum — planted around 2014, all bearing.",
                'features' => ['Built 2016, well maintained', '3 bedrooms, all attached', 'Borewell with storage tank', 'Solar water heater', '60+ fruit trees, bearing', 'Separate staff quarter', 'Covered parking for two cars'],
            ],
            [
                'title' => '10 Marla Residential Plot in Bhoj Jabial',
                'type' => 'plot', 'listing' => 'sale',
                'price' => 1450000, 'area' => 10, 'area_unit' => 'marla',
                'locality' => 'Bhoj Jabial', 'ownership' => 'Registry', 'facing' => 'East',
                'approach_road' => '12 ft village road',
                'is_featured' => true, 'sort_order' => 3,
                'cover_image' => $land, 'images' => [$land, $hill],
                'short_description' => 'A small, level plot inside the village — good for a first build or a weekend cottage.',
                'description' => "Level ground, which is not easy to find at this size in the hills. Inside the village boundary, so neighbours, shops and the school are all within walking distance.\n\nSuited to a modest two-bedroom build. Electricity and water are both at the boundary since the village line runs past it.",
                'features' => ['Level ground, no cutting needed', 'Inside village, all amenities close', 'Electricity and water at boundary', 'East facing, morning sun', 'Registry in seller name'],
            ],
            [
                'title' => '2 BHK Hill Cottage in Mandana',
                'type' => 'cottage', 'listing' => 'sale',
                'price' => 6800000, 'area' => 8, 'area_unit' => 'marla',
                'bedrooms' => 2, 'bathrooms' => 2,
                'locality' => 'Mandana', 'ownership' => 'Freehold', 'facing' => 'South',
                'approach_road' => 'Motorable up to the gate',
                'sort_order' => 4,
                'cover_image' => $cot, 'images' => [$cot, $view],
                'short_description' => 'Stone-and-timber cottage with a wraparound deck, ready to move into.',
                'description' => "Built in local stone with a timber roof, in the style that suits this weather better than concrete.\n\nTwo bedrooms, a wood-burning fireplace in the sitting room, and a deck running along two sides that catches sun from morning to late afternoon.\n\nCar reaches right up to the gate — worth saying, because at this height many cottages need a walk up.",
                'features' => ['Stone and timber construction', 'Wood-burning fireplace', 'Wraparound deck, south facing', 'Car reaches the gate', 'Furnished, ready to move in', 'Water tank and backup'],
            ],
            [
                'title' => '5 Acre Agricultural Land in Thandog',
                'type' => 'land', 'listing' => 'sale',
                'price' => 9500000, 'area' => 5, 'area_unit' => 'acre',
                'locality' => 'Thandog', 'ownership' => 'Freehold', 'facing' => 'West',
                'approach_road' => 'Kaccha road, 8 ft',
                'sort_order' => 5,
                'cover_image' => $land, 'images' => [$land, $view],
                'short_description' => 'Terraced farm land with a seasonal water channel running along the lower edge.',
                'description' => "Five acres in three terraces, already under cultivation. Wheat and maize have been grown here for years, so the soil is known and worked.\n\nA seasonal channel runs along the bottom edge and holds water from July into October. There is no borewell at present.\n\nThe approach is a kaccha road, fine for a tractor, hard for a car after heavy rain. Worth seeing in person before deciding.",
                'features' => ['Three level terraces', 'Under cultivation now', 'Seasonal water channel', 'Soil worked for years', 'Tractor accessible'],
            ],
            [
                'title' => 'Running 8-Room Resort near Morni Road',
                'type' => 'resort', 'listing' => 'sale',
                'price' => 47500000, 'area' => 3, 'area_unit' => 'acre',
                'bedrooms' => 8, 'bathrooms' => 8,
                'locality' => 'Morni', 'ownership' => 'Freehold', 'facing' => 'South-West',
                'approach_road' => 'Main road frontage',
                'sort_order' => 6,
                'cover_image' => $res, 'images' => [$res, $view, $house],
                'short_description' => 'An operating eight-room resort with main road frontage, sold as a going concern.',
                'description' => "Eight guest rooms, a dining hall that seats forty, a kitchen built for volume, and staff quarters — all on three acres with frontage on the main Morni road.\n\nRunning since 2019 with steady weekend occupancy. Books are open to a serious buyer.\n\nSold as a going concern: land, building, licences and existing bookings all transfer.",
                'features' => ['8 guest rooms, all attached', 'Dining hall seats 40', 'Commercial kitchen', 'Main road frontage', 'Staff quarters on site', 'Running since 2019', 'Licences transfer with sale'],
            ],
            [
                'title' => '2 BHK Cottage on Rent in Morni',
                'type' => 'cottage', 'listing' => 'rent',
                'price' => 25000, 'price_note' => 'per month',
                'area' => 6, 'area_unit' => 'marla',
                'bedrooms' => 2, 'bathrooms' => 2,
                'locality' => 'Morni', 'facing' => 'East',
                'approach_road' => 'Tar road to the gate',
                'sort_order' => 7,
                'cover_image' => $stay, 'images' => [$stay, $cot],
                'short_description' => 'Furnished two-bedroom cottage on long-term rent, close to the Morni market.',
                'description' => "Furnished and ready — beds, almirahs, kitchen fittings and a geyser are all in place.\n\nTen minutes' walk from the Morni market. Suited to a long stay rather than a weekend; the owner prefers a tenancy of eleven months or more.\n\nElectricity and water are on the tenant. Two months' deposit.",
                'features' => ['Fully furnished', 'Walking distance to market', 'Geyser and water storage', 'Parking for one car', 'Minimum 11-month tenancy'],
            ],
            [
                'title' => '4-Room Homestay with Orchard in Baldwala',
                'type' => 'homestay', 'listing' => 'sale',
                'price' => 15500000, 'area' => 1, 'area_unit' => 'acre',
                'bedrooms' => 4, 'bathrooms' => 4,
                'locality' => 'Baldwala', 'ownership' => 'Freehold', 'facing' => 'North-East',
                'approach_road' => '10 ft approach, motorable',
                'sort_order' => 8,
                'cover_image' => $stay, 'images' => [$stay, $view, $land],
                'short_description' => 'Small registered homestay on an acre of orchard, running through the season.',
                'description' => "Four rooms let out to guests, plus a separate owner's portion — so it can be run and lived in at the same time.\n\nRegistered under the Haryana homestay scheme, with the paperwork current. The orchard is mostly plum and apricot, about forty trees.\n\nDoes good business from March through June and again in October. The listing has photographs and past occupancy for anyone seriously interested.",
                'features' => ['4 guest rooms plus owner portion', 'Registered homestay, papers current', '40-tree orchard', 'Steady season occupancy', 'Motorable approach', 'Water storage and backup'],
            ],
        ];

        foreach ($rows as $r) {
            /* Str::slug, uniqueSlug nahi. uniqueSlug takraav par "-2"
               laga deta hai -- aur yahan takraav khud isi property ka
               hota hai, isliye har baar chalane par nakal ban jaati thi.
               PostSeeder mein yahi bug tha aur wahan theek ho chuka. */
            $r['slug']     = Str::slug($r['title']);
            $r['city']     = $r['city']     ?? 'Morni';
            $r['district'] = $r['district'] ?? 'Panchkula';
            $r['state']    = $r['state']    ?? 'Haryana';
            $r['pincode']  = $r['pincode']  ?? '134205';
            $r['status']   = $r['status']   ?? 'available';

            Property::updateOrCreate(['slug' => $r['slug']], $r);
        }
    }
}
