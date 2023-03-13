<?php

namespace App\Services;

use App\DTOs\DtoRenderedTemplate;
use App\DTOs\DtoTemplate;
use App\Enums\SlugEnum;
use App\Repositories\TemplateRepository;

class TemplateService
{
    public function __construct(private TemplateRepository $templateRepository)
    {
    }

    public function renderTemplate(DtoTemplate $dtoTemplate): DtoRenderedTemplate
    {
         $renderedTemplate =  match ($dtoTemplate->getSlug()) {
            SlugEnum::MOBILE_VERIFICATION->value => $this->renderPlainTextTemplate($dtoTemplate->getCode()),
            SlugEnum::EMAIL_VERIFICATION->value => $this->renderHtmlTemplate($dtoTemplate->getCode()),
        };

         $this->templateRepository->create($dtoTemplate, $renderedTemplate);
         return $renderedTemplate;
    }

    private function renderHtmlTemplate(string $code): DtoRenderedTemplate
    {
        $template = view('templates.email_verification', ['code' => $code])->render();

        return new DtoRenderedTemplate($template, [
            'Content-Type' => 'text/html',
            'charset' => 'UTF-8',
        ]);
    }

    private function renderPlainTextTemplate(string $code): DtoRenderedTemplate
    {
        $template = view('templates.sms_verification', ['code' => $code])->render();

        return new DtoRenderedTemplate($template, [
            'Content-Type' => 'text/plain',
            'charset' => 'UTF-8',
        ]);
    }

}
