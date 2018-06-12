<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return new JsonResponse([
            'Hello' => 'World',
        ]);
    }
}