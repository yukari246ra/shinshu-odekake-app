
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

{{-- メタディスクリプション --}}
<meta name="description" content="長野県の観光スポットを、利用シーン・エリア・カテゴリから探せるアプリ。家族・カップル・ひとりなど、目的に合わせておでかけ先が見つかります。">

{{-- OGP --}}
<meta property="og:title" content="信州おでかけアプリ">
<meta property="og:description" content="長野県の観光スポットをシーン・エリア・カテゴリから検索。">
<meta property="og:type" content="website">

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">

{{-- 日本語Webフォント：Noto Sans JP --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
<link href="https://fonts.bunny.net/css?family=noto-sans-jp:400,500,600,700" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
