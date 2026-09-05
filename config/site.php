<?php

/**
 * Dhande ki jaankari ek hi jagah.
 *
 * Phone number site par pandrah jagah aata hai -- header, footer, har
 * card, har form, schema. Har view mein likhte to badalne par ek-do
 * jagah chhoot jaati, aur wahi jagah customer ko milti.
 */
return [
    'name'       => 'Sky Property Morni Hills',
    'short_name' => 'Sky Property',
    'tagline'    => 'Your Dream Property, Our Commitment',
    'tagline_2'  => 'Live close to nature, away from noise',
    'tagline_3'  => 'Invest Today, Enjoy Tomorrow',

    'phone'         => '+91 83073 77270',
    'phone_link'    => '+918307377270',   // tel: aur WhatsApp ke liye
    'whatsapp'      => '918307377270',
    'email'         => 'balvindersingh134205@gmail.com',

    'address' => [
        'street'   => 'Morni',
        'locality' => 'Morni',
        'city'     => 'Panchkula',
        'district' => 'Panchkula',
        'state'    => 'Haryana',
        'pincode'  => '134205',
        'country'  => 'IN',
    ],

    'address_line' => 'Morni, Panchkula, Haryana 134205',

    /* Morni Hills ka madhya -- map aur schema dono isi se chalte hain */
    'geo' => ['lat' => '30.6884', 'lng' => '77.0870'],

    'hours' => 'Mon – Sun: 9:00 AM – 7:00 PM',

    /* Google Search Console ka verification.
       Google homepage par ye tag dhoondhta hai. Verify ho jaane ke baad
       bhi ise hatana nahi -- hataane par Google site ko dobara
       "unverified" kar deta hai aur Search Console band ho jaata hai. */
    'google_verification' => 'lE2HtazMQVm8UcWCpR0JS6pJuFijUbrNZjE9SEApR1g',

    /* Jin ilaakon mein kaam hai. Homepage aur footer dono yahi padhte
       hain, taaki nayi jagah ek hi baar likhni pade. */
    'areas' => [
        'Morni Hills',
        'Tikkar Taal',
        'Bhoj Jabial',
        'Mandana',
        'Thandog',
        'Baldwala',
        'Panchkula',
        'Pinjore',
        'Kalka',
        'Raipur Rani',
    ],
];
