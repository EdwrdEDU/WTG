<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('saved_event_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); 
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); 
            $table->timestamp('read_at')->nullable();
            $table->timestamp('scheduled_for')->nullable(); 
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
            
            $table->index(['account_id', 'read_at']);
            $table->index(['scheduled_for', 'is_sent']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};