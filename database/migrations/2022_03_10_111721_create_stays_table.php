<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stays', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->unsignedSmallInteger('square_meters');
            $table->unsignedSmallInteger('guests');
            $table->unsignedSmallInteger('rooms');
            $table->unsignedSmallInteger('beds');
            $table->unsignedSmallInteger('bathrooms');
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->string('street_address');
            $table->string('zip_code');
            $table->string('city');
            $table->string('province_state');
            $table->string('country');
            $table->text('image_path');
            $table->boolean('visible')->default(true);
            $table->decimal('price', 6, 2);
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stays');
    }
}
