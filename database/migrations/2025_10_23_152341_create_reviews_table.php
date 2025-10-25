<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');      // Viaje al que pertenece la reseña
            $table->unsignedBigInteger('passenger_id'); // Usuario que hace la reseña
            $table->unsignedBigInteger('driver_id');    // Conductor que recibe la reseña
            $table->tinyInteger('rating');              // Valor de 1 a 5 estrellas
            $table->text('comment')->nullable();        // Comentario opcional
            $table->timestamps();

            // Llaves foráneas:
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('passenger_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
