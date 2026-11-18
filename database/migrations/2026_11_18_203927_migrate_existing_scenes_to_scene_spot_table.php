<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 既存スポットの利用シーンを取得
        $spots = DB::table('spots')
            ->whereNotNull('scene')
            ->where('scene', '<>', '')
            ->get(['id', 'scene']);

        // 新しい中間テーブルへ移行
        foreach ($spots as $spot) {
            DB::table('scene_spot')->insert([
                'spot_id' => $spot->id,
                'scene' => $spot->scene,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 旧テーブルに保存されている利用シーンに対応するデータを削除
        $spots = DB::table('spots')
            ->whereNotNull('scene')
            ->where('scene', '<>', '')
            ->get(['id', 'scene']);

        foreach ($spots as $spot) {
            DB::table('scene_spot')
                ->where('spot_id', $spot->id)
                ->where('scene', $spot->scene)
                ->delete();
        }
    }
};
