<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->json('notification_preferences')->nullable();
            $table->json('notification_delivery')->default('["in_app"]');
            $table->boolean('notifications_enabled')->default(true);
        });
    }

    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['notification_preferences', 'notification_delivery', 'notifications_enabled']);
        });
    }
};