<?php

use App\Models\Spot;

it('1つのスポットに複数の利用シーンを登録できる', function () {
    $spot = Spot::create([
        'name' => 'テストスポット',
        'description' => 'テスト用の説明文です。',
    ]);

    $spot->syncScenes(['家族', '友達']);

    expect($spot->fresh()->sceneNames())
        ->toBe(['家族', '友達']);
});

it('利用シーンを変更すると以前のシーンが置き換わる', function () {
    $spot = Spot::create([
        'name' => 'テストスポット',
        'description' => 'テスト用の説明文です。',
    ]);

    $spot->syncScenes(['家族', '友達']);
    $spot->syncScenes(['カップル']);

    expect($spot->fresh()->sceneNames())
        ->toBe(['カップル']);
});

it('利用シーンが重複して登録されない', function () {
    $spot = Spot::create([
        'name' => 'テストスポット',
        'description' => 'テスト用の説明文です。',
    ]);

    $spot->syncScenes(['家族', '家族', '友達']);

    expect($spot->fresh()->sceneNames())
        ->toBe(['家族', '友達']);
});
