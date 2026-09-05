<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * .env mein MAIL_PASSWORD daalta hai, chhupe hue input se.
 *
 * Shell wala `read -r -p` teen baar fail ho chuka hai: paste ke saath
 * agli line hi password ban jaati thi, aur usmein `|` hone se sed bhi
 * toot jaata tha. Yahan teen cheezein alag hain --
 *
 *   1. input chhupa hua hai, isliye screenshot mein nahi jaata
 *   2. jo daala gaya wo jaancha jaata hai; agar wo shell command jaisa
 *      lagta hai (yaani galti se paste hua hai) to mana kar deta hai
 *   3. .env mein likhne ke liye sed nahi -- PHP file padhta aur likhta
 *      hai, to `|`, `$`, `"` jaise akshar kuch nahi todte
 */
class MailPassword extends Command
{
    protected $signature   = 'mail:password
                             {password? : Seedha bhi de sakte ho, warna poochha jayega}';

    protected $description = 'Email ka password .env mein daalta hai (chhupa hua input)';

    public function handle(): int
    {
        $env = base_path('.env');

        if (!is_writable($env)) {
            $this->error('  .env likhi nahi ja sakti: ' . $env);

            return self::FAILURE;
        }

        /* Do raaste: seedha argument, ya poochh kar. Argument isliye ki
           chhupa hua input har terminal par ek jaisa nahi chalta --
           agar wahan atak jaye to doosra raasta khula rehna chahiye.
           Jaanch dono par ek jaisi lagti hai. */
        if ($given = $this->argument('password')) {
            $given = $this->tidy((string) $given);

            if ($bad = $this->whatIsWrong((string) $given)) {
                $this->newLine();
                $this->error('  ' . $bad);
                $this->newLine();

                return self::FAILURE;
            }

            return $this->write($env, (string) $given);
        }

        $this->newLine();
        $this->line('  Email account ka password daalo. Type karte waqt kuch dikhega nahi --');
        $this->line('  ye theek hai. Type karke Enter dabao.');
        $this->newLine();

        for ($try = 1; $try <= 3; $try++) {
            $pw = $this->tidy((string) $this->secret('  Password'));

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

    /**
     * .env mein likhta hai.
     *
     * sed nahi, PHP se -- taaki password ke andar `|`, `$`, `"` jaise
     * akshar kuch na todein. Wahi sed wali line pichhli baar tooti thi.
     */
    private function write(string $env, string $pw): int
    {
        $s = file_get_contents($env);

        $line = 'MAIL_PASSWORD="' . str_replace(['\\', '"'], ['\\\\', '\\"'], $pw) . '"';

        $s = preg_match('~^MAIL_PASSWORD=.*$~m', $s)
            ? preg_replace('~^MAIL_PASSWORD=.*$~m', $line, $s, 1)
            : rtrim($s) . "\n" . $line . "\n";

        file_put_contents($env, $s);

        $this->newLine();
        $this->info('  Password daal diya (' . mb_strlen($pw) . ' akshar).');
        $this->line('  Ab jaanchne ke liye:  php artisan mail:test');
        $this->newLine();

        $this->call('config:clear');

        return self::SUCCESS;
    }

    /**
     * Google ka app password "abcd efgh ijkl mnop" ki shakl mein dikhata
     * hai. Wo spaces sirf padhne ke liye hain -- asli password 16 akshar
     * ka hai. Log jaisa dikhta hai waisa hi copy karte hain, isliye us
     * ek shakl mein spaces hata dete hain.
     *
     * Sirf usi shakl mein -- kisi aur password ke beech ke space ko haath
     * nahi lagate, warna sahi password bigad jaata.
     */
    private function tidy(string $pw): string
    {
        return preg_match('~^[a-z]{4}( [a-z]{4}){3}$~', trim($pw))
            ? str_replace(' ', '', trim($pw))
            : $pw;
    }

    /**
     * Galti se paste hui command pakadta hai.
     *
     * Har baar yahi hua hai: command dobara paste ho gayi aur wahi
     * "password" ban gayi. Asli password mein ye cheezein hoti hi nahi.
     */
    private function whatIsWrong(string $pw): ?string
    {
        if (trim($pw) === '') {
            return 'Kuch daala hi nahi.';
        }

        foreach (['artisan', 'read -r', 'MAIL_PASSWORD', 'sed -i', 'php ', 'cd ~', 'git '] as $sign) {
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

        if (mb_strlen($pw) < 6) {
            return 'Bahut chhota hai (' . mb_strlen($pw) . ' akshar). Poora password daalo.';
        }

        return null;
    }
}
