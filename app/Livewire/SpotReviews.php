<?php

namespace App\Livewire;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SpotReviews extends Component
{
    public int $spotId;

    // 入力フォーム（評価は0のとき「未選択」）
    public int $rating = 0;
    public string $body = '';

    // 自分の口コミを編集中かどうか
    public bool $isEditing = false;

    public function mount(int $spotId): void
    {
        $this->spotId = $spotId;
    }

    protected function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'between:1,5'],
            'body'   => ['required', 'string', 'max:500'],
        ];
    }

    protected function messages(): array
    {
        return [
            'rating.required' => '評価を星1〜5から選んでください。',
            'rating.between'  => '評価を星1〜5から選んでください。',
            'body.required'   => '口コミを入力してください。',
            'body.max'        => '口コミは500文字以内で入力してください。',
        ];
    }

    // ログイン中のユーザーが、このスポットに書いた口コミ（なければ null）
    protected function myReview(): ?Review
    {
        if (! Auth::check()) {
            return null;
        }

        return Review::where('user_id', Auth::id())
            ->where('spot_id', $this->spotId)
            ->first();
    }

    // 投稿（新規）と更新の両方をここで行う
    public function save(): void
    {
        // ゲストはログイン画面へ誘導
        if (! Auth::check()) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $this->validate();

        // 1スポット1人1件。すでにあれば上書き、なければ新規作成
        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'spot_id' => $this->spotId],
            ['rating' => $this->rating, 'body' => $this->body],
        );

        $this->resetForm();
    }

    // 自分の口コミを編集モードにする
    public function edit(): void
    {
        $review = $this->myReview();

        if (! $review) {
            return;
        }

        $this->rating = $review->rating;
        $this->body = $review->body;
        $this->isEditing = true;
        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    // 削除できるのは、本人または管理者だけ
    public function delete(int $reviewId): void
    {
        $review = Review::where('spot_id', $this->spotId)->findOrFail($reviewId);

        $user = Auth::user();

        abort_unless(
            $user && ($user->id === $review->user_id || $user->role === 'admin'),
            403
        );

        $review->delete();

        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['rating', 'body', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $reviews = Review::where('spot_id', $this->spotId)
            ->latest()
            ->get();

        return view('livewire.spot-reviews', [
            'reviews'     => $reviews,
            'reviewCount' => $reviews->count(),
            'average'     => $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : null,
            'myReview'    => $this->myReview(),
            'isAdmin'     => Auth::check() && Auth::user()->role === 'admin',
        ]);
    }
}