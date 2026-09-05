<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Site se aayi puchtaachh.
 *
 * `property_id` nullable hai kyunki do jagah se enquiry aati hai: kisi
 * ek property ke page se, ya contact form se jahan koi property chuni
 * hi nahi hoti. Dono ek hi jagah rakhne se dashboard mein ek hi list
 * dekhni padti hai.
 *
 * `seen_at` `status` se alag cheez hai. status batata hai ki aapne kya
 * kiya (naya / baat hui / band); seen_at sirf itna ki nazar padi ya
 * nahi. Sidebar ka badge isi par chalta hai.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('enquiries')) {
            return;
        }

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('message')->nullable();

            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();

            /* Property delete ho jaane par bhi ye reh jaata hai, taaki
               purani enquiry mein pata chale kis cheez ki thi. */
            $table->string('property_title')->nullable();

            $table->string('budget')->nullable();
            $table->string('source_page')->nullable();

            $table->string('status')->default('new');    // new | contacted | visited | closed
            $table->timestamp('seen_at')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('seen_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
