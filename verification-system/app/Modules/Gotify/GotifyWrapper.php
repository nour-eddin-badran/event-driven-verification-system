<?php

namespace App\Modules\Gotify;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GotifyWrapper
{
    private const SEND_MESSAGE_URL = '/message';

    private string $gotifyHost;
    private string $gotifyAppToken;


    public function __construct()
    {
        $this->gotifyHost = config('services.gotify.host');
        $this->gotifyAppToken = config('services.gotify.app_token');
    }

    public function sendMessage(string $message, string $title): void
    {
        $url = $this->getPreparedURL(self::SEND_MESSAGE_URL);
        $response = Http::post($url, [
            'message' => $message,
            'title' => $title
        ]);

        if (!$response->ok()) {
            Log::error($response->body());
        }
    }

    private function getPreparedURL(string $endpoint_key): string
    {
        $url = $this->gotifyHost . $endpoint_key;

        $params = http_build_query([
            'token' => $this->gotifyAppToken
        ]);

        return sprintf('%s?%s', $url, $params);
    }
}