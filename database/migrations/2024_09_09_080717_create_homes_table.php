<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 50)->unique();
            $table->string('slug', 55);
            $table->string('description', 250)->nullable();

            $table->unsignedTinyInteger('beds');
            $table->unsignedTinyInteger('bathrooms');
            $table->unsignedTinyInteger('rooms');
            $table->unsignedSmallInteger('square_metres');

            $table->string('address', 75);
            $table->string('lat', 20);
            $table->string('long', 20);
            $table->string('image', 250);
            $table->boolean('active')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homes');
    }
};
