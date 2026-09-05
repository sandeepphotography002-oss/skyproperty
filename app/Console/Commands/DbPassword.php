<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * .env mein DB_PASSWORD daalta hai.
 *
 * MailPassword jaisa hi, aur usi wajah se -- database ka password
 * hPanel se badalne ke baad .env mein bhi wahi daalna padta hai, warna
 * site database se jud hi nahi paati.
 *
 * sed se nahi likhte: database ke password mein aksar `@`, `$` ya `|`
 * hote hain aur wahi line pehle tod chuke hain. PHP file padh kar likh
 * deta hai, to koi bhi akshar kuch nahi bigadta.
 *
 * Ye command database ko chhuti nahi -- isliye tab bhi chalti hai jab
 * password badal chuka ho aur site jud na pa rahi ho.
 *
 *   php artisan db:password
 */
class DbPassword extends Command
{
    protected $signature = 'db:password {password? : Seedha bhi de sakte ho, warna poochha jayega}';

    protected $description = 'Database ka password .env mein daalta hai';

    public function handle(): int
    {
        $env = base_path('.env');

        if (!is_writable($env)) {
            $this->error('  .env likhi nahi ja sakti: ' . $env);

            return self::FAILURE;
        }

        if ($given = $this->argument('password')) {
            if ($bad = $this->whatIsWrong((string) $given)) {
                $this->newLine();
                $this->error('  ' . $bad);
                $this->newLine();

                return self::FAILURE;
            }

            return $this->write($env, (string) $given);
        }

        $this->newLine();
        $this->line('  hPanel se jo naya database password banaya, wo yahan daalo.');
        $this->line('  Type karte waqt kuch dikh sakta hai ya nahi bhi -- dono theek hai.');
        $this->newLine();

        for ($try = 1; $try <= 3; $try++) {
            $pw = trim((string) $this->secret('  Database password'));

            if ($bad = $this->whatIsWrong($pw)) {
                $this->error('  ' . $bad);
                $this->newLine();
                continue;
            }

            return $this->write($env, $pw);
        }

        $this->error('  Teen baar galat aaya. Dobara koshish karo.');

        return self::FAILURE;
    }

    private function write(string $env, string $pw): int
    {
        $s = file_get_contents($env);

        /* addslashes backslash aur quote dono sambhaal leta hai, isliye
           password ke andar koi bhi akshar ho .env tootti nahi. */
        $line = 'DB_PASSWORD="' . addslashes($pw) . '"';

        $s = preg_match('~^DB_PASSWORD=.*$~m', $s)
            ? preg_replace('~^DB_PASSWORD=.*$~m', $line, $s, 1)
            : rtrim($s) . "\n" . $line . "\n";

        file_put_contents($env, $s);

        $this->newLine();
        $this->info('  Password daal diya (' . mb_strlen($pw) . ' akshar).');
        $this->line('  Ab jaanchne ke liye:  php artisan db:check');
        $this->newLine();

        $this->call('config:clear');

        return self::SUCCESS;
    }

    /** Galti se paste hui command pakadta hai -- ye pehle kai baar hua hai. */
    private function whatIsWrong(string $pw): ?string
    {
        if (trim($pw) === '') {
            return 'Kuch daala hi nahi.';
        }

        foreach (['artisan', 'DB_PASSWORD', 'sed -i', 'php ', 'cd ~', 'git ', 'grep '] as $sign) {
            if (stripos($pw, $sign) !== false) {
                return 'Ye password nahi, ek command lagti hai — shayad galti se paste ho gayi. Sirf password type karo.';
            }
        }

        if (stripos($pw, 'YAHAN') !== false || stripos($pw, 'APNA') !== false) {
            return 'Ye placeholder hai, asli password nahi.';
        }

        if (mb_strlen($pw) > 80) {
            return 'Itna lamba password nahi hota (' . mb_strlen($pw) . ' akshar) — shayad kuch aur paste ho gaya.';
        }

        return null;
    }
}
