<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) امسح التكرارات وسيب أقل id لكل (book_id, author_id)
        //    الـ derived table لازم عشان MySQL بيرفض subquery على نفس الجدول في DELETE
        DB::statement('
            DELETE FROM author_book
            WHERE id NOT IN (
                SELECT keep_id FROM (
                    SELECT MIN(id) AS keep_id
                    FROM author_book
                    GROUP BY book_id, author_id
                ) AS t
            )
        ');

        // 2) امنع التكرار مستقبلاً
        Schema::table('author_book', function (Blueprint $table) {
            $table->unique(['book_id', 'author_id']);
        });
    }

    public function down(): void
    {
        Schema::table('author_book', function (Blueprint $table) {
            $table->dropUnique(['book_id', 'author_id']);
        });
    }
};