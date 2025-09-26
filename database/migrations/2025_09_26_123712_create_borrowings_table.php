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
    $table->unsignedBigInteger('member_id');
    $table->unsignedBigInteger('book_id');
    $table->date('borrowed_at');
    $table->date('due_date');
    $table->date('returned_at')->nullable();
    $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
    $table->decimal('fine_amount', 8, 2)->default(0);

    $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
    $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
    $table->timestamps();
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
