<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends BaseController
{
    protected function jsonResponse(string $json): Response
    {
        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    protected function badRequestJsonResponse($response = false): JsonResponse
    {
        return new JsonResponse($response, JsonResponse::HTTP_BAD_REQUEST);
    }
}
