<?php

declare(strict_types=1);

namespace App\Service\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Custom cavidator for validating the input GitHub url/name 
 *
 * @author  Paweł Przychodzień
 */


class GithubRepositoryLinkOrNameValidator extends ConstraintValidator
{
    /**
     * Method for retrieving repositories data
     * 
     * @param $value with value to check  
     * @param Constraint $constraint class
    */

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof GithubRepositoryLinkOrName) {
            throw new UnexpectedTypeException($constraint, GithubRepositoryLinkOrName::class);
        }


        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[A-Za-z]+\/[A-Za-z]+$/', $value, $matches) && !preg_match('^(http(s)?://github.com)/([a-zA-z0-9-_])*/([a-zA-z0-9-_])*(.git)?^', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}