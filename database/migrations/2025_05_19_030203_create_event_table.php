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
    public function up(): void
    {
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->foreignId('account_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('organizer')->nullable();
        $table->text('description');
        $table->unsignedBigInteger('category_id');
        $table->enum('event_type', ['in-person', 'online', 'hybrid']);
        $table->string('image');
        $table->date('start_date');
        $table->time('start_time');
        $table->string('venue_name')->nullable();
        $table->string('address')->nullable();
        $table->string('ticket_name');
        $table->integer('ticket_quantity');
        $table->double('ticket_price', 8, 2);
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
        Schema::dropIfExists('event');
    }
};
