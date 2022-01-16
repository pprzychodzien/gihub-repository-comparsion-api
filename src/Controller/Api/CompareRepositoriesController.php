<?php

declare (strict_types = 1);

namespace App\Controller\Api;

use App\Controller\AbstractController;
use App\Service\Api\CompareRepositoriesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * An API Controller for comparing GitHub Repositories
 *
 * @author  Paweł Przychodzień
 */

class CompareRepositoriesController extends AbstractController
{
    /**
     * Service for making the comparsion
     * 
     * @var CompareRepositoriesService
     */
    private $compareRepositoriesService;

    public function __construct(CompareRepositoriesService $compareRepositoriesService)
    {
        $this->compareRepositoriesService = $compareRepositoriesService;
    }

    /**
     * Main method
     *
     * @param  Request $request input request data
     * @return JsonResponse with result of the comparsion or error info 
    */

    public function compareAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ? json_decode($request->getContent(), true): [];
        $result = $this->compareRepositoriesService->validateAndCompare($data);
        if (isset($result['errors'])) {
            return $this->badRequestJsonResponse($result);
        }
        return new JsonResponse($result);
    }
}