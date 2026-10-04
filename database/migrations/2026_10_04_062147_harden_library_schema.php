<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // author_book: remove duplicates, then enforce uniqueness
        $keep = DB::table('author_book')->selectRaw('MIN(id) as id')->groupBy('book_id', 'author_id')->pluck('id');
        DB::table('author_book')->whereNotIn('id', $keep)->delete();
        $this->addIndex('author_book', ['book_id', 'author_id'], unique: true);

        // borrowings
        $this->restrictFk('borrowings', 'member_id', 'members');
        $this->restrictFk('borrowings', 'book_id', 'books');
        $this->addIndex('borrowings', ['member_id', 'book_id', 'returned_at']);
        $this->addIndex('borrowings', ['returned_at', 'due_date']);

        // reservations
        $this->restrictFk('reservations', 'member_id', 'members');
        $this->restrictFk('reservations', 'book_id', 'books');
        $this->addIndex('reservations', ['member_id', 'book_id', 'status']);

        // books.category_id and users.role_id
        $this->restrictFk('books', 'category_id', 'categories');
        $this->restrictFk('users', 'role_id', 'roles');

        // inventory CHECK (MySQL 8.0.16+ only)
        if (DB::getDriverName() === 'mysql') {
            $exists = DB::table('information_schema.table_constraints')
                ->where('constraint_schema', DB::raw('DATABASE()'))
                ->where('table_name', 'books')
                ->where('constraint_name', 'books_inventory_check')
                ->exists();

            if (! $exists) {
                DB::statement('ALTER TABLE books ADD CONSTRAINT books_inventory_check
                    CHECK (total_copies >= 0 AND available_quantity >= 0 AND available_quantity <= total_copies)');
            }
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE books DROP CHECK books_inventory_check');
        }
        Schema::table('author_book', fn (Blueprint $t) => $t->dropUnique(['book_id', 'author_id']));
        Schema::table('borrowings', function (Blueprint $t) {
            $t->dropIndex(['member_id', 'book_id', 'returned_at']);
            $t->dropIndex(['returned_at', 'due_date']);
        });
        Schema::table('reservations', fn (Blueprint $t) => $t->dropIndex(['member_id', 'book_id', 'status']));
    }

    private function addIndex(string $table, array $columns, bool $unique = false): void
    {
        if (Schema::hasIndex($table, $columns)) {
            return;
        }

        Schema::table($table, fn (Blueprint $t) => $unique ? $t->unique($columns) : $t->index($columns));
    }

    private function restrictFk(string $table, string $column, string $refTable): void
    {
        $current = null;
        foreach (Schema::getForeignKeys($table) as $fk) {
            if ($fk['columns'] === [$column]) {
                $current = strtolower($fk['on_delete']);
            }
        }

        if ($current === 'restrict') {
            return; // already done
        }

        Schema::table($table, function (Blueprint $t) use ($column, $refTable, $current) {
            if ($current !== null) {
                $t->dropForeign([$column]);
            }
            $t->foreign($column)->references('id')->on($refTable)->restrictOnDelete();
        });
    }
};