<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('interests', function (Blueprint $table) {
            $table->string('ticketmaster_classification')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->default('#6366f1');
        });
    }

    public function down()
    {
        Schema::table('interests', function (Blueprint $table) {
            $table->dropColumn(['ticketmaster_classification', 'icon', 'color']);
        });
    }
};