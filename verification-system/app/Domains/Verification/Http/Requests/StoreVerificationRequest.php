<?php

namespace App\Domains\Verification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Domains\Verification\Http\Validators\SubjectValidator;

class StoreVerificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (!$this->request->has('subject')) {
            throw new \Exception('Malformed JSON passed', Response::HTTP_BAD_REQUEST);
        }

        return SubjectValidator::getRules($this->request);
    }
}
