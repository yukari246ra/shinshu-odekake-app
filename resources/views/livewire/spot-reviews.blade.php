<section class="space-y-6">

    {{-- 見出しと平均評価 --}}
    <div class="flex flex-wrap items-end justify-between gap-3">
        <h2 class="flex items-center gap-2 text-xl font-bold text-heading">
            <flux:icon name="chat-bubble-left-right" class="size-5" />
            口コミ
        </h2>

        @if ($average !== null)
            <p class="flex items-center gap-2 text-sm text-slate-600">
                <span class="flex" aria-hidden="true">
                    @for ($i = 1; $i <= 5; $i++)
                        <flux:icon
                            name="star"
                            variant="solid"
                            class="size-5 {{ $i <= round($average) ? 'text-amber-400' : 'text-slate-200' }}"
                        />
                    @endfor
                </span>
                <span class="text-lg font-bold text-heading">{{ number_format($average, 1) }}</span>
                <span>（{{ $reviewCount }}件）</span>
            </p>
        @endif
    </div>

    {{-- 投稿フォーム --}}
    @guest
        <p class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-600 dark:bg-zinc-800">
            <a href="{{ route('login') }}" class="text-link underline">口コミ投稿にはログインが必要です</a>
        </p>
    @endguest

    @auth
        @if (! $myReview || $isEditing)
            <form
                wire:submit="save"
                class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:bg-zinc-800"
            >
                <h3 class="font-bold text-heading">
                    {{ $isEditing ? '口コミを編集する' : 'このスポットの口コミを書く' }}
                </h3>

                {{-- 星で評価 --}}
                <div>
                    <p class="mb-1 text-sm text-slate-600">評価</p>
                    <div class="flex items-center gap-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button
                                type="button"
                                wire:click="$set('rating', {{ $i }})"
                                aria-label="星{{ $i }}つ"
                                class="rounded p-0.5"
                            >
                                <flux:icon
                                    name="star"
                                    variant="solid"
                                    class="size-8 {{ $i <= $rating ? 'text-amber-400' : 'text-slate-200' }}"
                                />
                            </button>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 本文 --}}
                <div>
                    <label for="review-body" class="mb-1 block text-sm text-slate-600">口コミ（500文字まで）</label>
                    <textarea
                        id="review-body"
                        wire:model="body"
                        rows="4"
                        maxlength="500"
                        placeholder="行ってみた感想や、おすすめのポイントを書いてください"
                        class="w-full rounded-lg border border-slate-300 bg-white p-3 text-sm text-heading dark:bg-zinc-900"
                    ></textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3">
                    <flux:button type="submit" variant="primary" class="h-10 rounded-lg">
                        {{ $isEditing ? '更新する' : '投稿する' }}
                    </flux:button>

                    @if ($isEditing)
                        <flux:button type="button" wire:click="cancelEdit" class="h-10 rounded-lg">
                            キャンセル
                        </flux:button>
                    @endif
                </div>
            </form>
        @endif
    @endauth

    {{-- 口コミ一覧 --}}
    @if ($reviews->isEmpty())
        <p class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-500 dark:bg-zinc-800">
            まだ口コミがありません。最初の口コミを書いてみませんか。
        </p>
    @else
        <ul class="space-y-4">
            @foreach ($reviews as $review)
                @php
                    $isMine = auth()->check() && $review->user_id === auth()->id();
                @endphp

                <li
                    wire:key="review-{{ $review->id }}"
                    class="space-y-2 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:bg-zinc-800"
                >
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <span class="flex" aria-label="評価 {{ $review->rating }}">
                                @for ($i = 1; $i <= 5; $i++)
                                    <flux:icon
                                        name="star"
                                        variant="solid"
                                        class="size-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}"
                                    />
                                @endfor
                            </span>
                            <span class="text-sm font-medium text-heading">
                                {{ $isMine ? 'あなた' : 'ユーザー' }}
                            </span>
                        </div>
                        <span class="text-xs text-slate-500">{{ $review->created_at->format('Y/n/j') }}</span>
                    </div>

                    <p class="text-sm leading-relaxed text-slate-700">{!! nl2br(e($review->body)) !!}</p>

                    {{-- 編集は本人だけ。削除は本人と管理者 --}}
                    @if ($isMine || $isAdmin)
                        <div class="flex gap-4 pt-1 text-sm">
                            @if ($isMine)
                                <button type="button" wire:click="edit" class="text-link underline">編集</button>
                            @endif
                            <button
                                type="button"
                                wire:click="delete({{ $review->id }})"
                                wire:confirm="この口コミを削除しますか？"
                                class="text-red-600 underline"
                            >
                                削除
                            </button>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

</section>