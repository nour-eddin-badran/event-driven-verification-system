<?php

namespace App\Repositories;

use App\DTOs\DtoRenderedTemplate;
use App\DTOs\DtoTemplate;
use App\Models\Template;

class TemplateRepository
{
    public function __construct(private Template $template) { }

    public function create(DtoTemplate $templateInfo, DtoRenderedTemplate $renderedTemplate)
    {
        $this->template->create([
            'slug' => $templateInfo->getSlug(),
            'code' => $templateInfo->getCode(),
            'content' => $renderedTemplate->getTemplate()
        ]);
    }
}