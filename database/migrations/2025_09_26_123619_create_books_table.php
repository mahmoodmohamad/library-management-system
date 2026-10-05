<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('isbn')->unique();
    $table->foreignId('publisher_id')->nullable()->constrained();
    $table->text('description');
    $table->year('publication_year');
    $table->integer('pages');
    $table->integer('available_quantity');
    $table->integer('total_copies');
    $table->string('shelf_location')->nullable();
    $table->foreignId('category_id')->constrained()->restrictOnDelete();
    $table->softDeletes();
    $table->timestamps();
});

if (DB::getDriverName() === 'mysql') {
    DB::statement('ALTER TABLE books ADD CONSTRAINT books_inventory_check
        CHECK (total_copies >= 0 AND available_quantity >= 0 AND available_quantity <= total_copies)');
}
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('books');
}
};
