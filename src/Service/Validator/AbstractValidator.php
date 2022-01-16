<?php

declare(strict_types=1);

namespace App\Service\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $data, array $constraintData = []): ConstraintViolationListInterface
    {
        $constraints = $this->constraints($constraintData);

        return $this->validator->validate($data, $constraints);
    }

    public function violationArray(ConstraintViolationListInterface $violationsList): array
    {
        foreach ($violationsList as $violation) {
            $property = $violation->getPropertyPath() ? $result[$violation->getPropertyPath()] = $violation->getMessage(): $result["fatal_error"] = "The input data should not be blank";
        }
        return $result ?? [];
    }

    abstract protected function constraints(array $data = []): array;
}
