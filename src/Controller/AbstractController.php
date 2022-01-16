<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * An Abstract Controller implementing methods for returning results with status codes
 *
 * @author  Paweł Przychodzień
 */

abstract class AbstractController extends BaseController
{
    /**
     * Method for returning success responses
     *
     * @param string $json string representation of the data to return
     * @return Response with OK status code and response info. 
    */

    protected function jsonResponse(string $json): Response
    {
        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * Method for returning bad request responses with error info
     *
     * @param string $response (optional) string representation of the error info to return
     * @return JsonResponse with BAD_REQUEST status code and optional error info.
    */

    protected function badRequestJsonResponse($response = ''): JsonResponse
    {
        return new JsonResponse($response, JsonResponse::HTTP_BAD_REQUEST);
    }
}
