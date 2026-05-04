<?php
namespace Validators;
use Src\Validator\AbstractValidator;

class NullableValidator extends AbstractValidator
{
    public function rule(): bool
    {
        return true;
    }
}