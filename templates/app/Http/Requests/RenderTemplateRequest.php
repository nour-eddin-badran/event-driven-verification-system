<?php

namespace App\Http\Requests;

use App\Enums\SlugEnum;
use Illuminate\Validation\Rule;

class RenderTemplateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public static function rules()
    {
        return [
            'slug' => ['required', Rule::in(SlugEnum::MOBILE_VERIFICATION->value, SlugEnum::EMAIL_VERIFICATION->value)],
            'variables' => 'required|array',
            'variables.code' => ['required', 'numeric']
        ];
    }
}
