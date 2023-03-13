<?php

namespace App\Jobs;

use App\Modules\Kafka\Contracts\HasBody;
use App\Modules\Kafka\KafkaParam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;

class DispatchToKafka implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private KafkaParam $kafkaParam)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $kafka = Kafka::publishOn($this->kafkaParam->getTopicName());

            if ( $this->kafkaParam instanceof HasBody) {
                $param = $this->kafkaParam->getBody();
                $kafka->withBodyKey($param->getKey(), $param->getValue());
            }

            $kafka->send();
        } catch (\Throwable $e)
        {
            Log::error($e->getMessage());
        }
    }
}
