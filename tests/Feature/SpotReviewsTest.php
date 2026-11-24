<?php

use App\Livewire\SpotReviews;
use App\Models\Review;
use App\Models\Spot;
use App\Models\User;
use Livewire\Livewire;

// テスト用のスポットを作る
function reviewSpot(): Spot
{
    return Spot::create([
        'name' => '口コミ用スポット',
        'description' => 'テスト用の説明文です。',
    ]);
}

// 指定したユーザーの口コミを作る
function reviewBy(User $user, Spot $spot, int $rating = 4, string $body = 'とても良かったです。'): Review
{
    return Review::create([
        'user_id' => $user->id,
        'spot_id' => $spot->id,
        'rating' => $rating,
        'body' => $body,
    ]);
}

// ---------- 投稿 ----------

it('ログインしている人は口コミを投稿できる', function () {
    $user = User::factory()->create();
    $spot = reviewSpot();

    $this->actingAs($user);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 5)
        ->set('body', '景色がきれいでした。')
        ->call('save')
        ->assertHasNoErrors();

    $review = Review::first();

    expect(Review::count())->toBe(1)
        ->and($review->user_id)->toBe($user->id)
        ->and($review->spot_id)->toBe($spot->id)
        ->and($review->rating)->toEqual(5)
        ->and($review->body)->toBe('景色がきれいでした。');
});

it('ログインしていない人は口コミを投稿できず、ログイン画面に移動する', function () {
    $spot = reviewSpot();

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 5)
        ->set('body', '投稿してみます。')
        ->call('save')
        ->assertRedirect(route('login'));

    expect(Review::count())->toBe(0);
});

it('評価が未選択のときは投稿できない', function () {
    $this->actingAs(User::factory()->create());
    $spot = reviewSpot();

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('body', '星を選び忘れました。')
        ->call('save')
        ->assertHasErrors(['rating']);

    expect(Review::count())->toBe(0);
});

it('本文が空のときは投稿できない', function () {
    $this->actingAs(User::factory()->create());
    $spot = reviewSpot();

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 4)
        ->set('body', '')
        ->call('save')
        ->assertHasErrors(['body']);

    expect(Review::count())->toBe(0);
});

it('本文は500文字まで投稿でき、501文字はエラーになる', function () {
    $this->actingAs(User::factory()->create());
    $spot = reviewSpot();

    // 501文字はエラー
    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 3)
        ->set('body', str_repeat('あ', 501))
        ->call('save')
        ->assertHasErrors(['body']);

    expect(Review::count())->toBe(0);

    // 500文字はOK
    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 3)
        ->set('body', str_repeat('あ', 500))
        ->call('save')
        ->assertHasNoErrors();

    expect(Review::count())->toBe(1);
});

it('同じ人が同じスポットに2回投稿しても1件のままで、内容が更新される', function () {
    $user = User::factory()->create();
    $spot = reviewSpot();

    $this->actingAs($user);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 2)
        ->set('body', '1回目の口コミ')
        ->call('save');

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->set('rating', 5)
        ->set('body', '2回目の口コミ')
        ->call('save');

    $review = Review::first();

    expect(Review::count())->toBe(1)
        ->and($review->rating)->toEqual(5)
        ->and($review->body)->toBe('2回目の口コミ');
});

// ---------- 編集 ----------

it('自分の口コミを編集して更新できる', function () {
    $user = User::factory()->create();
    $spot = reviewSpot();
    $review = reviewBy($user, $spot, 3, '編集前の口コミ');

    $this->actingAs($user);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->call('edit')
        ->assertSet('isEditing', true)
        ->assertSet('rating', 3)
        ->assertSet('body', '編集前の口コミ')
        ->set('rating', 5)
        ->set('body', '編集後の口コミ')
        ->call('save')
        ->assertSet('isEditing', false);

    expect(Review::count())->toBe(1)
        ->and($review->fresh()->rating)->toEqual(5)
        ->and($review->fresh()->body)->toBe('編集後の口コミ');
});

// ---------- 削除と認可 ----------

it('自分の口コミを削除できる', function () {
    $user = User::factory()->create();
    $spot = reviewSpot();
    $review = reviewBy($user, $spot);

    $this->actingAs($user);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->call('delete', $review->id);

    expect(Review::count())->toBe(0);
});

it('他の人の口コミは削除できない', function () {
    $author = User::factory()->create();
    $other = User::factory()->create();
    $spot = reviewSpot();
    $review = reviewBy($author, $spot);

    $this->actingAs($other);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->call('delete', $review->id)
        ->assertForbidden();

    expect(Review::count())->toBe(1);
});

it('管理者は他の人の口コミを削除できる', function () {
    $author = User::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $spot = reviewSpot();
    $review = reviewBy($author, $spot);

    $this->actingAs($admin);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->call('delete', $review->id);

    expect(Review::count())->toBe(0);
});

// ---------- 表示 ----------

it('他の人の口コミは「ユーザー」と表示され、名前は出ない。自分の口コミは「あなた」と表示される', function () {
    $author = User::factory()->create(['name' => '山田太郎']);
    $viewer = User::factory()->create(['name' => '佐藤花子']);
    $spot = reviewSpot();
    reviewBy($author, $spot, 4, '山田さんの口コミ本文');
    reviewBy($viewer, $spot, 5, '佐藤さんの口コミ本文');

    $this->actingAs($viewer);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->assertSee('ユーザー')
        ->assertSee('あなた')
        ->assertDontSee('山田太郎')
        ->assertDontSee('佐藤花子');
});

it('平均評価と件数が表示される', function () {
    $spot = reviewSpot();
    reviewBy(User::factory()->create(), $spot, 5);
    reviewBy(User::factory()->create(), $spot, 4);

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->assertSee('4.5')
        ->assertSee('2件');
});

it('口コミがないときは案内文が表示される', function () {
    $spot = reviewSpot();

    Livewire::test(SpotReviews::class, ['spotId' => $spot->id])
        ->assertSee('まだ口コミがありません');
});

it('スポット詳細画面に口コミが表示される', function () {
    $spot = reviewSpot();
    reviewBy(User::factory()->create(), $spot, 4, '詳細画面で見える口コミです');

    $this->get(route('spot', $spot))
        ->assertOk()
        ->assertSee('詳細画面で見える口コミです');
});