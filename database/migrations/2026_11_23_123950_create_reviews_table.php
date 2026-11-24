<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spot_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1〜5（範囲は入力チェックで確認）
            $table->text('body');
            $table->timestamps();

            // 1スポットにつき1人1件
            $table->unique(['user_id', 'spot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};