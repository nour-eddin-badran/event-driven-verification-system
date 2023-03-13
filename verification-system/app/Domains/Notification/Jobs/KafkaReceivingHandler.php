<?php

namespace App\Domains\Notification\Jobs;

use App\Domains\Notification\DTOs\DtoReceivedVerification;
use App\Domains\Notification\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use function Symfony\Component\String\match;

class KafkaReceivingHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private KafkaConsumerMessage $message)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationService = app(NotificationService::class);
        $bodyProperties = $this->message->getBody()["properties"];
        match($this->message->getTopicName()) {
            'VerificationCreated' => $this->handleVerificationCreated($notificationService, $bodyProperties),
            'VerificationConfirmed' => $this->handleVerificationConfirmed($notificationService, $bodyProperties),
        };
    }

    private function handleVerificationCreated(NotificationService $notificationService, array $bodyProperties)
    {
        $notificationService->handleVerificationCreated(new DtoReceivedVerification(
            $bodyProperties['id'],
            $bodyProperties['code'],
            $bodyProperties['subject']['identity'],
            $bodyProperties['subject']['type'],
            $bodyProperties['occurredOn']
        ));
    }

    private function handleVerificationConfirmed(NotificationService $notificationService, array $bodyProperties)
    {

    }
}
