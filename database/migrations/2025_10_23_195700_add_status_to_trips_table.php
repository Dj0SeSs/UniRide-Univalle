<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTripsTable extends Migration
{
    public function up()
{
    Schema::table('trips', function (Blueprint $table) {
        $table->string('status')->default('Pendiente')->after('available_seats');
    });
}

public function down()
{
    Schema::table('trips', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

}
