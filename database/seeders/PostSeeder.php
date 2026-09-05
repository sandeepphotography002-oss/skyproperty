<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Blog ke lekh.
 *
 * Har lekh apni file mein hai -- database/seeders/posts/*.php -- aur
 * wahan se ek array lautata hai. Sab ek hi file mein hote to wo 60 KB
 * ki ho jaati aur ek lekh badalne ke liye poora file kholna padta.
 *
 * updateOrCreate slug par chalta hai, isliye dobara chalane par nakal
 * nahi banti -- par likha hua badal kar dobara chalao to lekh sudhar
 * jaata hai. Yahi tareeka hai content update karne ka.
 *
 *   php artisan db:seed --class=PostSeeder --force
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        $dir   = __DIR__ . '/posts';
        $files = glob($dir . '/*.php') ?: [];

        /* _ se shuru hone wali file lekh nahi hai -- wo sabke saath
           baanti jaane wali cheezein rakhti hai. */
        $shared = is_file($dir . '/_shared-faq.php') ? require $dir . '/_shared-faq.php' : [];
        $files  = array_values(array_filter($files, fn ($p) => !str_starts_with(basename($p), '_')));

        if (!$files) {
            $this->command?->warn('posts/ folder khaali hai.');

            return;
        }

        /* Purani tareekh pehle wale ko, nayi baad wale ko -- taaki blog
           par ek hi din ke paanch lekh na dikhein. */
        $day = count($files);

        foreach ($files as $file) {
            $row = require $file;

            if (!is_array($row) || blank($row['title'] ?? null)) {
                $this->command?->warn('chhoda: ' . basename($file));
                continue;
            }

            /* Seedha Str::slug, uniqueSlug nahi. uniqueSlug takraav par
               "-2" laga deta hai -- aur yahan wo takraav khud is post ka
               hota, isliye har baar chalane par ek nayi nakal ban jaati. */
            $slug = $row['slug'] ?? Str::slug($row['title']);

            /* Apni faq na ho to sabki wali mil jaati hai, aur nishaan
               lag jaata hai taaki uska schema na bheja jaye. */
            if (empty($row['faq']) && $shared) {
                $row['faq']        = $shared;
                $row['faq_shared'] = true;
            }

            $row += [
                'status'      => 'published',
                'author_name' => 'Sky Property Morni Hills',
                'author_bio'  => 'We buy, sell and arrange land in Morni and around Panchkula, and we live here. '
                               . 'Call +91 83073 77270 with anything this article did not answer.',
            ];

            /* published_at sirf naye lekh par set kar rahe hain. Maujood
               lekh ki tareekh badal dete to har seed par wo "aaj ka"
               ban jaata aur Google ko galat sanket jaata. */
            $existing = Post::where('slug', $slug)->first();
            if (!$existing) {
                $row['published_at'] = now()->subDays(--$day);
            } else {
                unset($row['published_at']);
            }

            $row['slug'] = $slug;

            Post::updateOrCreate(['slug' => $slug], $row);

            $this->command?->line('  ' . $row['title']);
        }

        $this->command?->info(count($files) . ' post taiyaar.');
    }
}
