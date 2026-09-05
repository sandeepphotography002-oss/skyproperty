<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Database se jud paa rahe hain ya nahi -- seedha bata deta hai.
 *
 * Password badalne ke baad site kholkar guess karne se behtar hai ki
 * yahin se pata chal jaye, aur galti ho to asli wajah dikhe.
 */
class DbCheck extends Command
{
    protected $signature = 'db:check';

    protected $description = 'Database ka connection jaanchta hai';

    public function handle(): int
    {
        $this->newLine();

        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            $this->error('  Database se jud nahi paa rahe.');
            $this->newLine();
            $this->line('  Wajah: ' . $e->getMessage());
            $this->newLine();
            $this->line('  Password galat ho to dobara:  php artisan db:password');
            $this->newLine();

            return self::FAILURE;
        }

        $this->info('  Jud gaye. Database: ' . DB::connection()->getDatabaseName());
        $this->line('  Andar hai: ' . Post::count() . ' blog post, ' . Property::count() . ' property');
        $this->newLine();

        return self::SUCCESS;
    }
}
