<?php

namespace App\Domains\Notification\Services;

use App\Domains\Notification\DTOs\DtoNotification;
use App\Domains\Notification\DTOs\DtoReceivedVerification;
use App\Domains\Notification\Repositories\NotificationRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function handleVerificationCreated(DtoReceivedVerification $dtoReceivedVerification)
    {
        $renderedTemplate = $this->fetchTemplate($dtoReceivedVerification->getType(), $dtoReceivedVerification->getCode());
        $this->notificationRepository->create(
            new DtoNotification($dtoReceivedVerification->getIdentity(), $dtoReceivedVerification->getType(), $renderedTemplate)
        );

    }

    private function fetchTemplate(string $slug, string $code): string
    {
        $template_base_url = config('services.template_base_url');
        $response = Http::post("$template_base_url/templates/render", [
           'slug' => $slug,
            'variables' => [
                'code' => $code
            ]
        ]);

        if (!$response->ok()) {
            throw new \Exception('Failed to fetch the template(' . $response->body() . ')', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->body();
    }
}