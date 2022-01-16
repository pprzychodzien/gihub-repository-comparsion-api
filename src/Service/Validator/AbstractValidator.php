<?php

declare(strict_types=1);

namespace App\Service\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * An abstract validator class
 *
 * @author  Paweł Przychodzień
 */


abstract class AbstractValidator
{
    /**
     * Basic validator interface
     * 
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Method adding the constraints to validator
     *
     * @param array $data an array with payload to validate
     * @return ConstraintViolationListInterface list of constraints violations
    */

    public function validate(array $data, array $constraintData = []): ConstraintViolationListInterface
    {
        $constraints = $this->constraints($constraintData);

        return $this->validator->validate($data, $constraints);
    }

    /**
     * Method parsing ConstraintViolationListInterface into array
     *
     * @param ConstraintViolationListInterface list of constraints violations
     * @return array list of violations as an array
    */

    public function violationArray(ConstraintViolationListInterface $violationsList): array
    {
        foreach ($violationsList as $violation) {
            $property = $violation->getPropertyPath() ? $result[$violation->getPropertyPath()] = $violation->getMessage(): $result["fatal_error"] = "The input data should not be blank";
        }
        return $result ?? [];
    }

    /**
     * Abstract functionfor getting constraints for payload validation
     *
     * @return array with constraints to use in validation
    */

    abstract protected function constraints(): array;
}
