<?php

declare(strict_types=1);

namespace App\Service\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Custom constraint for validating the input GitHub url/name 
 *
 * @author  Paweł Przychodzień
 */

class GithubRepositoryLinkOrName extends Constraint
{
    /**
     * Message to return if the constraint was broken
     * 
     * @var string
     */

    public $message = 'This value is not a valid github repository link or name.';
}