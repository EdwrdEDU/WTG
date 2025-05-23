<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            
            // For local events (created by users)
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            
            // For external events (from Ticketmaster API)
            $table->string('external_event_id')->nullable();
            $table->string('external_source')->default('ticketmaster'); // in case we add other APIs later
            
            // Store event data for external events
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('event_url')->nullable();
            $table->datetime('event_date')->nullable();
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('price_info')->nullable();
            
            $table->timestamps();
            
            // Prevent duplicate saves
            $table->unique(['account_id', 'event_id']);
            $table->unique(['account_id', 'external_event_id', 'external_source']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_events');
    }
};