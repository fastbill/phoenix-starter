<?php

declare(strict_types=1);

namespace Fastbill\Phoenix\Starter\Http\Controller;

use Fastbill\Phoenix\Framework\Modules\View\Http\Controller\ViewController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends ViewController
{
    public function handleRequest(Request $request, array $args): Response
    {
        return $this->createHtmlResponse($request, 'home', [
            'title' => 'Phoenix Starter App',
        ]);
    }
}
