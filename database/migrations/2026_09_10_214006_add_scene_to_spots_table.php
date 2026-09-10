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
        Schema::table('spots', function (Blueprint $table) {
            // 利用シーン（scene）を追加
            // nullable にする理由：
            // 既存データ（松本城など）を壊さないため
            $table->string('scene')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            // rollback 時に scene カラムを削除
            $table->dropColumn('scene');
        });
    }
};

