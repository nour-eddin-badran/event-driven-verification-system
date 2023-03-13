<?php

namespace App\Domains\Verification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class VerificationConfirmRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => ['required', 'numeric']
        ];
    }
}
