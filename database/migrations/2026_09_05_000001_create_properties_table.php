<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sky Property ka maal -- plot, zameen, farmhouse, cottage, resort,
 * homestay, aur kiraye wali property. Sab ek hi table mein hain,
 * `type` se alag hote hain.
 *
 * Ek hi table isliye ki inme farak sirf do-teen field ka hai. Plot ke
 * bedroom nahi hote, cottage ke hote hain -- bas. Alag table banate to
 * har listing page par saat query lagti aur "sab dikhao" bhi mushkil
 * ho jaata.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('properties')) {
            return;
        }

        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            /* plot | land | farmhouse | cottage | resort | homestay */
            $table->string('type')->default('plot');

            /* sale | rent -- kiraya alag type nahi hai, kyunki ek hi
               cottage bik bhi sakta hai aur kiraye par bhi ja sakta hai */
            $table->string('listing')->default('sale');

            /* Daam number mein, taaki chhote-bade se sort aur filter ho
               sake. 0 ka matlab "poochh kar bataayenge" -- price_note
               mein wahi likha jaata hai. */
            $table->unsignedBigInteger('price')->default(0);
            $table->string('price_note')->nullable();       // "per marla", "monthly"

            /* Pahaad par zameen marla, kanal aur acre teeno mein bikti
               hai. Ek hi unit maan lete to har listing galat dikhti. */
            $table->decimal('area', 12, 2)->nullable();
            $table->string('area_unit')->default('marla');  // marla | kanal | acre | sq ft

            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();

            $table->string('locality')->nullable();         // Morni, Tikkar Taal, Bhoj Jabial
            $table->string('city')->default('Morni');
            $table->string('district')->default('Panchkula');
            $table->string('state')->default('Haryana');
            $table->string('pincode')->default('134205');

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            /* JSON list -- "Road touch", "Water connection", "Valley view" */
            $table->longText('features')->nullable();
            $table->longText('images')->nullable();
            $table->string('cover_image')->nullable();

            /* Kaagaz ki baat. Pahaadi zameen mein log sabse pehle yahi
               poochhte hain, isliye ye alag field hai, description mein
               dabi hui nahi. */
            $table->string('ownership')->nullable();        // Freehold, Registry, Power of Attorney
            $table->string('facing')->nullable();
            $table->string('approach_road')->nullable();

            $table->string('map_embed')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('available');  // available | sold | rented | hidden

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('type');
            $table->index('listing');
            $table->index('status');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
