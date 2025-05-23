<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
   Schema::table('accounts', function (Blueprint $table) {
        $table->string('profile_image')->nullable();
        $table->string('country')->nullable();
        $table->string('phone')->nullable();          
        $table->date('date_of_birth')->nullable();     
    });
}

public function down()
{
    Schema::table('accounts', function (Blueprint $table) {
        $table->dropColumn(['profile_image', 'country']);
    });
}
};
