<?php

declare(strict_types=1);

namespace App\Service\Validator;

use Symfony\Component\Validator\Constraint;


class GithubRepositoryLinkOrName extends Constraint
{
    public $message = 'This value is not a valid github repository link or name.';
}