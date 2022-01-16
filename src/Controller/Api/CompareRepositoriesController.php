<?php

declare (strict_types = 1);

namespace App\Controller\Api;

use App\Controller\AbstractController;
use App\Service\Api\CompareRepositoriesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompareRepositoriesController extends AbstractController
{
    /**
     * @var CompareRepositoriesService
     */
    private $compareRepositoriesService;

    public function __construct(CompareRepositoriesService $compareRepositoriesService)
    {
        $this->compareRepositoriesService = $compareRepositoriesService;
    }

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