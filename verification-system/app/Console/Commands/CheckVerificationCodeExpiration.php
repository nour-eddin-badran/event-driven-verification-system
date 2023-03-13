<?php

namespace App\Console\Commands;

use App\Domains\Verification\Models\Verification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckVerificationCodeExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is responsible for checking the validity of the verification code';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Verification::where(['confirmed' => false, 'is_expired' => false])->where('attempts_count', '<', 5)
            ->whereRaw("DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 5 MINUTE), '%Y-%m-%d %H:%i') >= DATE_FORMAT(`created_at`, '%Y-%m-%d %H:%i')")
            ->update([
                'is_expired' => true
            ]);
    }
}
