<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DurationTransformer implements DataTransformerInterface
{
    public function __construct()
    {
    }

    /** From int to [int, int] */
    public function transform(mixed $value): mixed
    {
        if (!$value || !is_int($value)) {
            return ['hour' => 0, 'minute' => 0];
        }

        return [
            'hour' => intdiv($value, 60),
            'minute' => $value % 60,
        ];
    }

    public function reverseTransform(mixed $value): mixed
    {
        $errMessage = 'Value %s is not a valid duration.';

        if (!$value || !is_array($value) || 2 != count($value)) {
            $failure = new TransformationFailedException(sprintf($errMessage, $value));
            $failure->setInvalidMessage(sprintf($errMessage, $value));

            throw $failure;
        }

        return $value['hour'] * 60 + $value['minute'];
    }
}
