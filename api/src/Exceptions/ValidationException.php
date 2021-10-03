<?php

namespace App\Exceptions;

use Symfony\Component\Form\FormErrorIterator;

class ValidationException extends AppException
{
    public function __construct(private FormErrorIterator $errors)
    {
        parent::__construct('Ошибка валидации');
    }

    public function getErrors(): FormErrorIterator
    {
        return $this->errors;
    }
}