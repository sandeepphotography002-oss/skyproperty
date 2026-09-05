<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nishaan ki is lekh ki FAQ apni nahi, sabke saath baanti hui hai.
 *
 * Sawaal to page par dikhte rahenge -- padhne wale ke liye wo kaam ke
 * hain. Par FAQPage schema sirf un lekhon par jaata hai jinke apne
 * sawaal hain.
 *
 * Wajah: bilkul ek jaisi FAQ ka schema pandrah page se bhejna Google
 * ko batata hai ki ye pandrah page ek hi cheez hain. Wahi doorway
 * pages ka nishaan hai, aur uspar poori site par kaarwai hoti hai.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('posts') || Schema::hasColumn('posts', 'faq_shared')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('faq_shared')->default(false)->after('faq');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('posts', 'faq_shared')) {
            Schema::table('posts', fn (Blueprint $t) => $t->dropColumn('faq_shared'));
        }
    }
};
