<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // لو فيه duplicates موجودة، الـ unique هيفشل. نظّفها الأول:
        // نحوّل الـ users للـ role الأقدم ونمسح الباقي.
        $duplicates = DB::table('roles')
            ->select('name', DB::raw('MIN(id) as keep_id'))
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            $extraIds = DB::table('roles')
                ->where('name', $dup->name)
                ->where('id', '!=', $dup->keep_id)
                ->pluck('id');

            DB::table('users')
                ->whereIn('role_id', $extraIds)
                ->update(['role_id' => $dup->keep_id]);

            DB::table('roles')->whereIn('id', $extraIds)->delete();
        }

        Schema::table('roles', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};