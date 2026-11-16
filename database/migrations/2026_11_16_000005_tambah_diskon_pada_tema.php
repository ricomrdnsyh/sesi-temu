<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tema', function (Blueprint $table): void {
            $table->enum('diskon_tipe', ['nominal', 'persen'])->nullable()->after('harga');
            $table->unsignedInteger('diskon_nilai')->default(0)->after('diskon_tipe');
        });
    }

    public function down(): void
    {
        Schema::table('tema', function (Blueprint $table): void {
            $table->dropColumn(['diskon_tipe', 'diskon_nilai']);
        });
    }
};
