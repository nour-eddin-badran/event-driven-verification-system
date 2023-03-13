<?php

namespace App\Modules\Kafka\Contracts;

interface KafkaContractDispatchable
{
    public function getTopicName(): string;
}