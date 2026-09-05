<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Seeder ki banayi hui nakal hataata hai.
 *
 * Do wajah se nakal bani:
 *
 *   1. PropertySeeder slug ke liye uniqueSlug istemaal karta tha. Wo
 *      takraav par "-2" laga deta hai -- aur takraav khud usi property
 *      ka hota tha, isliye har baar chalane par ek nayi copy.
 *
 *   2. Blog ke slug chhote kiye gaye. File mein naya chhota slug tha,
 *      server ke database mein purana lamba. Seeder ne naye slug ko nayi
 *      cheez samajh kar 43 aur post bana diye.
 *
 * Kaun si rehti hai -- ye umar se tay NAHI hota. Umar se karte to blog
 * mein lamba purana slug bach jaata aur chhota nya slug mit jaata, yaani
 * jo chaahiye tha wahi chala jaata. Isliye:
 *
 *   - post   : wahi rehti hai jiska slug seeder ki file mein likha hai
 *   - property: wahi rehti hai jiska slug title se seedha banta hai
 *               (yaani bina "-2" wali)
 *
 * Aisi koi na mile to sabse purani reh jaati hai.
 *
 * Ek hi row wale title ko haath nahi lagta, isliye maalik ki apni daali
 * hui cheez surakshit hai.
 *
 *   php artisan data:dedupe          -- sirf dikhao
 *   php artisan data:dedupe --force  -- sach mein hatao
 */
class DataDedupe extends Command
{
    protected $signature = 'data:dedupe {--force : Sach mein hatao, sirf dikhao mat}';

    protected $description = 'Ek hi title wali nakal hataata hai (blog aur property dono)';

    public function handle(): int
    {
        $go = (bool) $this->option('force');

        $this->newLine();
        $this->line($go ? '  Hata rahe hain…' : '  Sirf dikha rahe hain (hatane ke liye --force lagao)');

        $total = 0;
        $total += $this->clean(Post::class, 'Blog post', $go, $this->slugsFromPostFiles());
        $total += $this->clean(Property::class, 'Property', $go, null);

        $this->newLine();

        if ($total === 0) {
            $this->info('  Koi nakal nahi mili. Sab theek hai.');
        } elseif ($go) {
            $this->info('  ' . $total . ' nakal hata di.');
            $this->line('  Bache: ' . Post::count() . ' post, ' . Property::count() . ' property');
        } else {
            $this->warn('  ' . $total . ' nakal milin. Hatane ke liye:  php artisan data:dedupe --force');
        }

        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Seeder ki post files se sahi slug uthata hai -- wahi jo PostSeeder
     * khud banata hai, taaki dono ek hi baat kahein.
     *
     * @return array<string,true>
     */
    private function slugsFromPostFiles(): array
    {
        $dir  = database_path('seeders/posts');
        $out  = [];

        foreach (glob($dir . '/*.php') ?: [] as $file) {
            if (str_starts_with(basename($file), '_')) {
                continue;
            }

            $row = require $file;

            if (!is_array($row) || blank($row['title'] ?? null)) {
                continue;
            }

            $out[$row['slug'] ?? Str::slug($row['title'])] = true;
        }

        return $out;
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @param  array<string,true>|null  $canonical  null = title se slug bana lo
     */
    private function clean(string $model, string $label, bool $go, ?array $canonical): int
    {
        $rows = $model::orderBy('id')->get(['id', 'title', 'slug']);

        /* Title ko dhile roop mein milaate hain -- bade-chhote akshar aur
           extra space se farak nahi padna chahiye. */
        $groups = $rows->groupBy(fn ($r) => mb_strtolower(trim(preg_replace('~\s+~', ' ', (string) $r->title))));

        $removed = 0;

        foreach ($groups as $group) {
            if ($group->count() < 2) {
                continue;
            }

            $keep = $this->pick($group, $canonical);
            $drop = $group->reject(fn ($r) => $r->id === $keep->id);

            $this->newLine();
            $this->line('  ' . $label . ': ' . mb_substr($group->first()->title, 0, 58));
            $this->line('     rakh rahe   : /' . $keep->slug);

            foreach ($drop as $d) {
                $this->line('     hata rahe   : /' . $d->slug);

                if ($go) {
                    $model::whereKey($d->id)->delete();
                }

                $removed++;
            }
        }

        return $removed;
    }

    /**
     * Group mein se wo row jiska slug sahi hai. Na mile to sabse purani.
     *
     * @param  \Illuminate\Support\Collection  $group
     * @param  array<string,true>|null  $canonical
     */
    private function pick($group, ?array $canonical)
    {
        $want = $canonical === null
            ? Str::slug((string) $group->first()->title)
            : null;

        $match = $group->first(fn ($r) => $canonical === null
            ? $r->slug === $want
            : isset($canonical[$r->slug]));

        return $match ?: $group->first();
    }
}
