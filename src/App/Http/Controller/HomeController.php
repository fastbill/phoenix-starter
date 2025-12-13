<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Fastbill\Phoenix\Framework\Modules\View\Http\Controller\ViewController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Home Controller
 *
 * A simple controller demonstrating the Phoenix ViewController pattern.
 * ViewController provides convenient methods for rendering Twig templates.
 *
 * Controllers in Phoenix:
 * - Can be invokable (implement __invoke or handleRequest)
 * - Receive the Request and route args
 * - Should be thin - delegate business logic to services
 */
class HomeController extends ViewController
{
    /**
     * Handle the home page request.
     *
     * @param Request $request The HTTP request
     * @param array $args Route parameters
     * @return Response
     */
    public function handleRequest(Request $request, array $args): Response
    {
        return $this->createHtmlResponse($request, 'home', [
            'title' => 'Welcome to Phoenix Framework',
        ]);
    }
}
