<?php

declare(strict_types=1);

namespace App\Service\Api\Validator;

use App\Service\Validator\GithubRepositoryLinkOrName;
use App\Service\Validator\AbstractValidator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Validator for GitHub repositories comparsion input payload
 *
 * @author  Paweł Przychodzień
 */

class RepositoryComparePayloadValidator extends AbstractValidator
{
    /**
     * Method for payload validation
     *
     * @param array $data an array with payload to validate
     * @return array an empty array or an array with error info
    */

    public function validatePayload(array $data): array
    {
        $result = $this->validate($data);
        if ($result->count() > 0) {
            return $this->violationArray($result);
        }
        return [];
    }

    /**
     * Method for getting constraints for payload validation
     *
     * @return array with constraints to use in validation
    */

    public function constraints(): array
    {
     
        return [new Assert\NotBlank(), new Assert\Collection([
            "repositories" => new Assert\Collection([
                "first_repo" => new GithubRepositoryLinkOrName(),
                "second_repo" => new GithubRepositoryLinkOrName()
            ])]) 
        ];
    }

}
