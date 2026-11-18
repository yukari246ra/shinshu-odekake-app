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
        Schema::create('scene_spot', function (Blueprint $table) {
            $table->id();

            // スポットとの紐づけ
            $table->foreignId('spot_id')
                ->constrained('spots')
                ->cascadeOnDelete();

            // 利用シーン
            $table->string('scene');

            // 同じスポットに同じシーンを重複登録できないようにする
            $table->unique(['spot_id', 'scene']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scene_spot');
    }
};