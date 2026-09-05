<?php

namespace App\Console\Commands;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Mail ki jaanch, bina form bhare.
 *
 * Bina iske maalik ko pata hi nahi chalta ki mail ja rahi hai ya nahi --
 * form bharo, "Thank you" dikhta hai chahe mail gayi ho ya nahi (aur
 * wahi theek bhi hai, warna grahak ko error dikhta). Ye command wo
 * pardah hata deti hai.
 *
 *   php artisan mail:test
 *   php artisan mail:test --to=koi@aur.com
 */
class MailTest extends Command
{
    protected $signature = 'mail:test {--to= : Kis par bhejein (na do to config wala)}';

    protected $description = 'Ek test enquiry mail bhej kar dekhta hai ki settings sahi hain ya nahi';

    public function handle(): int
    {
        $this->newLine();
        $this->line('  Abhi ki settings:');

        $rows = [
            ['MAIL_MAILER',       config('mail.default')],
            ['MAIL_HOST',         config('mail.mailers.smtp.host')],
            ['MAIL_PORT',         config('mail.mailers.smtp.port')],
            ['MAIL_USERNAME',     config('mail.mailers.smtp.username')],
            ['MAIL_PASSWORD',     $this->maskPassword((string) config('mail.mailers.smtp.password'))],
            ['MAIL_FROM_ADDRESS', config('mail.from.address')],
            ['NOTIFY_EMAIL',      config('site.notify_email')],
        ];

        foreach ($rows as [$k, $v]) {
            printf("    %-18s %s\n", $k, $v === null || $v === '' ? '(khaali)' : $v);
        }

        /* Sabse aam galtiyan pehle hi pakad lete hain, taaki SMTP ka
           dhundhla error padhna na pade. */
        $pw = (string) config('mail.mailers.smtp.password');

        if (str_contains($pw, 'YAHAN') || str_contains($pw, 'APNA')) {
            $this->newLine();
            $this->error('  MAIL_PASSWORD mein asli password nahi, placeholder likha hai.');

            return self::FAILURE;
        }

        if (config('mail.default') === 'log') {
            $this->newLine();
            $this->warn('  MAIL_MAILER=log hai -- mail bhejii nahi jaati, sirf storage/logs mein likhi jaati hai.');
        }

        $to = $this->option('to') ?: config('site.notify_email');

        if (blank($to)) {
            $this->newLine();
            $this->error('  NOTIFY_EMAIL khaali hai, to bhejna kahan hai.');

            return self::FAILURE;
        }

        /* Asli enquiry banate nahi -- sirf ek nakli object jise mail
           template padh sake. Database mein kuch nahi jaata. */
        $fake = new Enquiry([
            'name'           => 'Test enquiry',
            'phone'          => '+91 83073 77270',
            'email'          => 'test@example.com',
            'budget'         => '₹25 – 50 Lakh',
            'message'        => 'Ye sirf jaanch ke liye hai. Agar ye mail aapko mili hai, to settings sahi hain.',
            'property_title' => null,
            'source_page'    => url('/'),
        ]);
        $fake->created_at = now();

        $this->newLine();
        $this->line('  Bhej rahe hain: ' . $to . ' …');

        try {
            Mail::to(array_filter(array_map('trim', explode(',', (string) $to))))
                ->send(new EnquiryReceived($fake));
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('  NAHI GAYI.');
            $this->line('  ' . $e->getMessage());
            $this->newLine();
            $this->line('  Aam wajah:');
            $this->line('   - email account hPanel mein bana hi nahi');
            $this->line('   - MAIL_USERNAME poora email hona chahiye, sirf naam nahi');
            $this->line('   - password galat');
            $this->line('   - port 465 ke saath MAIL_ENCRYPTION=ssl, 587 ke saath tls');
            $this->newLine();

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('  BHEJ DI. Ab ' . $to . ' ka inbox dekho (spam bhi).');
        $this->newLine();

        return self::SUCCESS;
    }

    /** Password poora nahi dikhate -- screenshot mein chala jaata hai. */
    private function maskPassword(string $pw): string
    {
        if ($pw === '') { return '(khaali)'; }
        if (str_contains($pw, 'YAHAN') || str_contains($pw, 'APNA')) { return $pw . '  ← placeholder!'; }

        return str_repeat('*', max(4, mb_strlen($pw) - 2)) . mb_substr($pw, -2);
    }
}
