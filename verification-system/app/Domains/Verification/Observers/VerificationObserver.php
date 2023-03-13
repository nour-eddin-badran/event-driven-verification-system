<?php

namespace App\Domains\Verification\Observers;

use App\Domains\Verification\Modules\Kafka\Events\VerificationConfirmedParam;
use App\Domains\Verification\Modules\Kafka\Events\VerificationCreatedParam;
use App\Jobs\DispatchToKafka;
use App\Domains\Verification\Models\Verification;

class VerificationObserver
{
    public function created(Verification $verification)
    {
        DispatchToKafka::dispatch(new VerificationCreatedParam($verification));
    }

    public function updated(Verification $verification)
    {
        if ($verification->isDirty('confirmed')) {
            DispatchToKafka::dispatch(new VerificationConfirmedParam($verification));
        }
    }
}
