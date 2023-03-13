<?php

namespace App\Domains\Verification\Http\Validators;

use App\Domains\Verification\Enums\SubjectTypeEnum;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\InputBag;

class SubjectValidator
{
    public static function getRules(InputBag $request): array
    {
        $rules = [
            'subject' => 'array',
            'subject.type' => ['required', 'string', Rule::in([SubjectTypeEnum::MOBILE_CONFIRMATION->value, SubjectTypeEnum::EMAIL_CONFIRMATION->value])]
            ];
            $subject = $request->getIterator('subject')->current();
            if (isset($subject['type']) && $subject['type'] === SubjectTypeEnum::EMAIL_CONFIRMATION->value) {
            $rules['subject.identity'] = ['required', 'string', 'email', 'max:50'];

        } else if (isset($subject['type']) && $subject['type'] === SubjectTypeEnum::MOBILE_CONFIRMATION->value) {
            $rules['subject.identity'] = ['required', 'max:15', 'regex:/^(\+|0)[0-9]*$/'];
        }

        return $rules;
    }
}