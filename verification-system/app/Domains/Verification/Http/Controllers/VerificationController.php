<?php

namespace App\Domains\Verification\Http\Controllers;

use App\Domains\Verification\DTOs\DtoVerification;
use App\Domains\Verification\Http\Requests\StoreVerificationRequest;
use App\Domains\Verification\Http\Requests\VerificationConfirmRequest;
use App\Domains\Verification\Models\Verification;
use App\Domains\Verification\Services\VerificationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    public function __construct(private VerificationService $verificationService)
    {
    }

    public function store(StoreVerificationRequest $request)
    {
        $subject = $request->validated()['subject'];
        $verification = $this->verificationService->storeVerification(new DtoVerification($subject['identity'], $subject['type']));

        return response([
            'id' => $verification->uuid
        ], Response::HTTP_CREATED);
    }

    public function confirm(VerificationConfirmRequest $request, Verification $verification)
    {
        $this->verificationService->confirmVerification($verification, $request->code);
        return response([], Response::HTTP_NO_CONTENT);
    }
}
