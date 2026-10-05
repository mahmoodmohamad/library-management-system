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
       Schema::create('borrowings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('member_id')->constrained()->restrictOnDelete();
    $table->foreignId('book_id')->constrained()->restrictOnDelete();
    $table->date('borrowed_at');
    $table->date('due_date');
    $table->date('returned_at')->nullable();
    $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
    $table->decimal('fine_amount', 8, 2)->default(0);
    $table->timestamps();

    $table->index(['member_id', 'book_id', 'returned_at']);
    $table->index(['returned_at', 'due_date']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
