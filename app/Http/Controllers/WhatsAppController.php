<?php

namespace App\Http\Controllers;

use App\Services\AiSensyService;

class WhatsAppController extends Controller
{
    protected $aisensy;

    public function __construct(AiSensyService $aisensy)
    {
        $this->aisensy = $aisensy;
    }

    public function send()
    {
        $response = $this->aisensy->sendTemplate(
            phone: request()->phone,
            campaign: request()->campaign,
            userName: "Teachinghood",
            templateParams: []
        );

        return response()->json($response);
    }
}
