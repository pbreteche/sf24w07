<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DurationTransformer implements DataTransformerInterface
{
    public function __construct()
    {
    }

    /** From (int) minutes to (string) "hours:minutes" */
    public function transform(mixed $value): mixed
    {
        if (!$value || !is_int($value)) {
            return '00:00';
        }

        return sprintf('%02d:%02d', intdiv($value, 60), $value % 60);
    }

    public function reverseTransform(mixed $value): mixed
    {
        $errMessage = 'Value %s is not a valid duration.';
        if (!preg_match('#^(\d+):([0-5][0-9])$#', $value, $matches)) {
            $failure = new TransformationFailedException(sprintf($errMessage, $value));
            $failure->setInvalidMessage(sprintf($errMessage, $value));

            throw $failure;
        }

        return ((int) $matches[1]) * 60 + ((int) $matches[2]);
    }
}
