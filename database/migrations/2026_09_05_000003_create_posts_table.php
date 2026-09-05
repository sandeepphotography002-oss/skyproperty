<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Blog.
 *
 * Property listings se alag table hai, aur hona bhi chahiye. Listing bik
 * jaane par hat jaati hai; ek lekh "Morni mein zameen kaise kharidein"
 * saalon tak kaam karta rehta hai aur Google se log usi par aate hain.
 * Dono ek table mein daalte to listing delete karte hi lekh bhi jaata.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('posts')) {
            return;
        }

        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('guide');   // guide | area | investment | news

            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            $table->string('cover_image')->nullable();
            $table->string('cover_alt')->nullable();

            /* Lekhak ka naam column mein hai, users table se joda hua
               nahi. Blog par jo naam chhapna hai wo aksar login wale
               naam se alag hota hai, aur account hat jaane par lekh ka
               lekhak gayab nahi hona chahiye. */
            $table->string('author_name')->nullable();
            $table->text('author_bio')->nullable();

            /* Har lekh ke apne sawaal-jawab, JSON mein. Inhi se page par
               accordion banta hai aur FAQPage schema bhi. */
            $table->longText('faq')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('draft');     // draft | published

            /* Alag column, created_at nahi. Lekh aaj likha ja sakta hai
               aur agle hafte chhapna ho sakta hai, aur sitemap mein wahi
               tareekh jaani chahiye jo padhne wale ko dikhti hai. */
            $table->timestamp('published_at')->nullable();

            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index('status');
            $table->index('category');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
