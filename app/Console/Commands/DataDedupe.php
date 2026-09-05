<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Property;
use Illuminate\Console\Command;

/**
 * Seeder ki banayi hui nakal hataata hai.
 *
 * Do wajah se nakal bani:
 *
 *   1. PropertySeeder slug banane ke liye uniqueSlug istemaal karta tha.
 *      Wo takraav par "-2" laga deta hai -- aur takraav khud usi
 *      property ka hota tha, isliye har baar chalane par ek nayi copy.
 *
 *   2. Blog ke slug chhote kiye gaye. File mein naya slug tha, server ke
 *      database mein purana. Seeder ne naye slug ko nayi cheez samajh
 *      kar 43 aur post bana diye.
 *
 * Safai ka usool: ek hi title wali cheezon mein sabse purani (sabse
 * chhoti id) rakhi jaati hai, baaki hataayi jaati hain. Maalik ki
 * apni daali hui cheez ka title alag hoga, isliye wo chhui nahi jaati.
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
        $total += $this->clean(Post::class, 'Blog post', $go);
        $total += $this->clean(Property::class, 'Property', $go);

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
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     */
    private function clean(string $model, string $label, bool $go): int
    {
        $rows = $model::orderBy('id')->get(['id', 'title', 'slug']);

        /* Title ko dhile roop mein milaate hain -- bade-chhote akshar aur
           extra space se farak nahi padna chahiye. */
        $groups = $rows->groupBy(fn ($r) => mb_strtolower(trim(preg_replace('~\s+~', ' ', (string) $r->title))));

        $removed = 0;

        foreach ($groups as $title => $group) {
            if ($group->count() < 2) {
                continue;
            }

            /* Sabse purani rehti hai. Uske link kahin bheje ja chuke ho
               sakte hain; baad wali abhi banii hai. */
            $keep = $group->first();
            $drop = $group->slice(1);

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
}
