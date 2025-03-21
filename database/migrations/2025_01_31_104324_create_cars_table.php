<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('license_plate')->unique();
            $table->string('brand');
            $table->string('model');
            $table->decimal('price', 10, 2);
            $table->integer('mileage');
            $table->integer('seats');
            $table->integer('doors');
            $table->integer('production_year');
            $table->decimal('weight', 8, 2);
            $table->string('color');
            $table->json('images')->nullable(); // Store image paths as a JSON array
            $table->timestamp('sold_at')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
}