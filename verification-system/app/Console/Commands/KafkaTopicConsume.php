<?php

namespace App\Console\Commands;

use App\Domains\Notification\Jobs\KafkaReceivingHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;


class KafkaTopicConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topic:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $consumer = Kafka::createConsumer()
                ->withBrokers('kafka-test:9092')
                ->subscribe(['VerificationCreated'])
                ->withHandler(function (KafkaConsumerMessage $message) {
                    // Handle your message here
                    KafkaReceivingHandler::dispatch($message);

                })->build();

            $consumer->consume();
        } catch (\Throwable $e) {

        }
    }
}
