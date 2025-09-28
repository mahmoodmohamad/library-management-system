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
        Schema::create('members', function (Blueprint $table) {
    $table->id();
    $table->string('member_number')->unique(); // رقم عضوية فريد
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('phone');
    $table->text('address');
    $table->date('date_of_birth');
    $table->enum('membership_type', ['student', 'teacher', 'staff', 'public']);
    $table->date('membership_start_date');
    $table->date('membership_expiry_date');
    $table->string('emergency_contact_name');
    $table->string('emergency_contact_phone');
    $table->enum('status', ['active', 'suspended', 'expired'])->default('active');
    $table->decimal('outstanding_fines', 8, 2)->default(0);
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
