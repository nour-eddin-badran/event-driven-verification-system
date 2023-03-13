<?php

namespace App\Modules\Kafka\Contracts;

use App\Modules\Kafka\DTOs\DtoKafkaParam;

interface HasBody
{
    public function getBody(): DtoKafkaParam;
}