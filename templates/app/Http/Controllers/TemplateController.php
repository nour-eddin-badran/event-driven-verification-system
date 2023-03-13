<?php

namespace App\Http\Controllers;

use App\DTOs\DtoTemplate;
use App\Http\Requests\RenderTemplateRequest;
use App\Http\Controllers\Controller;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TemplateController extends Controller
{
    public function __construct(private TemplateService $templateService)
    {
    }

    public function render(Request $request)
    {
        $this->validate($request, RenderTemplateRequest::rules());

        $dtoRenderedTemplate = $this->templateService->renderTemplate(new DtoTemplate($request->slug, $request->variables['code']));

        return response($dtoRenderedTemplate->getTemplate(), Response::HTTP_OK)
            ->withHeaders($dtoRenderedTemplate->getHeaders());
    }
}