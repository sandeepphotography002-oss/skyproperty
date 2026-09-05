<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Admin account banata ya uska password badalta hai.
 *
 * Site par register ka rasta nahi hai, isliye pehla account yahin se
 * banta hai. Password bhool jaane par bhi yahi command chalti hai --
 * wahi email dobara dene par password badal jaata hai, naya user nahi
 * banta.
 *
 *   php artisan make:admin
 *   php artisan make:admin --email=me@site.com --name="Sandeep"
 */
class MakeAdmin extends Command
{
    protected $signature = 'make:admin
                            {--email= : Login email}
                            {--name=  : Naam}
                            {--password= : Password (na do to poochha jayega)}';

    protected $description = 'Admin account banata hai, ya maujood ka password badalta hai';

    public function handle(): int
    {
        $email = $this->option('email') ?: $this->ask('Email');
        $name  = $this->option('name')  ?: $this->ask('Naam', 'Admin');

        $password = $this->option('password') ?: $this->secret('Password (kam se kam 8 akshar)');

        if (strlen((string) $password) < 8) {
            $this->error('Password kam se kam 8 akshar ka hona chahiye.');

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password), 'email_verified_at' => now()],
        );

        $this->newLine();
        $this->info($user->wasRecentlyCreated
            ? "Admin ban gaya: {$email}"
            : "Password badal diya: {$email}");
        $this->line('  Login: ' . url('/login'));
        $this->newLine();

        return self::SUCCESS;
    }
}
