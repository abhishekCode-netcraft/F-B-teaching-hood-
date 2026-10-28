<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiSensyService
{
    protected $url;
    protected $apiKey;

    public function __construct()
    {
        $this->url = config('aisensy.base_url');
        $this->apiKey = config('aisensy.api_key');
    }

    public function sendTemplate(
        $phone,
        $campaign,
        $userName,
        array $templateParams = [],
        array $paramsFallbackValue = [],
        array $media = [],
    ) {
        $buttons = [
            [
                "type" => "button",
                "sub_type" => "url",
                "index" => 0,
                "parameters" => [
                    [
                        "type" => "text",
                        "text" => $templateParams[0]
                    ]
                ]
            ]
        ];

        $payload = [
            "apiKey" => $this->apiKey,
            "campaignName" => $campaign,
            "destination" => $phone,
            "userName" => $userName,
            "templateParams" => $templateParams,
            "source" => "Laravel",
            "media" => $media,
            "buttons" => $buttons,
            "carouselCards" => [],
            "location" => [],
            "attributes" => [],
            "paramsFallbackValue" => $paramsFallbackValue
        ];

        $response = Http::timeout(30)
            ->acceptJson()
            ->post($this->url, $payload);

        return $response->json();
    }
}
