<?php

declare(strict_types=1);

namespace App\Service\Api\Validator;

use App\Service\Validator\GithubRepositoryLinkOrName;
use App\Service\Validator\AbstractValidator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;


class RepositoryComparePayloadValidator extends AbstractValidator
{
    public function validatePayload(array $data): array
    {
        $result = $this->validate($data);
        if ($result->count() > 0) {
            return $this->violationArray($result);
        }
        return [];
    }

    public function constraints(array $data = []): array
    {
     
        return [new Assert\NotBlank(), new Assert\Collection([
            "repositories" => new Assert\Collection([
                "first_repo" => new GithubRepositoryLinkOrName(),
                "second_repo" => new GithubRepositoryLinkOrName()
            ])]) 
        ];
    }

}
