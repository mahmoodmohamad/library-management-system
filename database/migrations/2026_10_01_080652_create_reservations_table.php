<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('reservations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('member_id')->constrained()->restrictOnDelete();
    $table->foreignId('book_id')->constrained()->restrictOnDelete();
    $table->string('status')->default('active'); // active | fulfilled | cancelled | expired
    $table->timestamp('fulfilled_at')->nullable();
    $table->timestamps();

    $table->index(['book_id', 'status']);
    $table->index(['member_id', 'book_id', 'status']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
