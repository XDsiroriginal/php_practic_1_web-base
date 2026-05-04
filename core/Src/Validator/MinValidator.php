<?php
namespace Validators;
use Src\Validator\AbstractValidator;

class MinValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать минимум :min символов';

    public function rule(): bool
    {
        $min = (int)($this->args[0] ?? 0);
        return mb_strlen((string)$this->value) >= $min;
    }
}