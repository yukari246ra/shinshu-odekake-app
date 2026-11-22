<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WeatherService
{
    private const ENDPOINT = 'https://api.open-meteo.com/v1/forecast';

    // キャッシュの保存時間（分）
    private const CACHE_MINUTES = 30;

    // 予報の日数（今日を含む）
    private const FORECAST_DAYS = 7;

    /**
     * 指定した緯度・経度の天気を取得する（30分キャッシュ）。
     * 取得に失敗した場合は、例外を出さず null を返す。
     */
    public function fetch(float|string $latitude, float|string $longitude): ?array
    {
        // 戻り値の形を変えたので、キーに v2 を付けて古いキャッシュを読まないようにする
        $key = sprintf(
            'weather:v2:%s:%s',
            number_format((float) $latitude, 2, '.', ''),
            number_format((float) $longitude, 2, '.', '')
        );

        $cached = Cache::get($key);

        if (is_array($cached)) {
            return $cached;
        }

        $weather = $this->fetchFromApi($latitude, $longitude);

        // 成功したときだけ保存する（失敗は保存しない）
        if ($weather !== null) {
            Cache::put($key, $weather, now()->addMinutes(self::CACHE_MINUTES));
        }

        return $weather;
    }

    /**
     * Open-Meteo APIから天気を取得する。失敗時は null。
     */
    private function fetchFromApi(float|string $latitude, float|string $longitude): ?array
    {
        try {
            $response = Http::timeout(5)->get(self::ENDPOINT, [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,apparent_temperature,weather_code',
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max',
                'timezone' => 'Asia/Tokyo',
                'forecast_days' => self::FORECAST_DAYS,
            ]);

            if ($response->failed()) {
                Log::warning('天気APIがエラーを返しました', ['status' => $response->status()]);

                return null;
            }

            $data = $response->json();
            $current = $data['current'] ?? null;
            $daily = $data['daily'] ?? null;

            if (! is_array($current) || ! is_array($daily) || ! is_array($daily['time'] ?? null)) {
                Log::warning('天気APIの応答の形式が想定と違います');

                return null;
            }

            $code = $current['weather_code'] ?? null;

            // 7日分の予報を、1日ごとの配列にまとめる
            $days = [];
            foreach ($daily['time'] as $i => $date) {
                $dayCode = $daily['weather_code'][$i] ?? null;

                $days[] = [
                    'date' => $date,
                    'weather_code' => $dayCode,
                    'weather_label' => $this->label($dayCode),
                    'temperature_max' => $daily['temperature_2m_max'][$i] ?? null,
                    'temperature_min' => $daily['temperature_2m_min'][$i] ?? null,
                    'precipitation_probability' => $daily['precipitation_probability_max'][$i] ?? null,
                ];
            }

            return [
                // 現在の値
                'temperature' => $current['temperature_2m'] ?? null,
                'apparent_temperature' => $current['apparent_temperature'] ?? null,
                'weather_code' => $code,
                'weather_label' => $this->label($code),

                // 今日の値（今の画面が使っているので残す）
                'temperature_max' => $daily['temperature_2m_max'][0] ?? null,
                'temperature_min' => $daily['temperature_2m_min'][0] ?? null,
                'precipitation_probability' => $daily['precipitation_probability_max'][0] ?? null,

                // 週間予報（今日を含む7日分）
                'daily' => $days,
            ];
        } catch (Throwable $e) {
            Log::warning('天気の取得に失敗しました', ['message' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * 天気コード（WMO）を日本語の天気名に変換する。
     */
    private function label(?int $code): string
    {
        return match (true) {
            $code === 0 => '快晴',
            $code === 1 => '晴れ',
            $code === 2 => 'くもり時々晴れ',
            $code === 3 => 'くもり',
            in_array($code, [45, 48], true) => '霧',
            $code !== null && $code >= 51 && $code <= 57 => '霧雨',
            $code !== null && $code >= 61 && $code <= 67 => '雨',
            $code !== null && $code >= 71 && $code <= 77 => '雪',
            $code !== null && $code >= 80 && $code <= 82 => 'にわか雨',
            in_array($code, [85, 86], true) => 'にわか雪',
            $code !== null && $code >= 95 => '雷雨',
            default => '不明',
        };
    }
}