<?php

namespace App\Form\TypeGuesser;

use App\Service\LocaleRegionMapper;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess;

readonly class ReflectionNamedTypeGuesser implements FormTypeGuesserInterface
{
    public function __construct (private LocaleRegionMapper $mapper) {}
    public function guessType(string $class, string $property): ?Guess\TypeGuess
    {
        $type = $this->getReflectionType($class, $property);

        if (!$type) {
            return null;
        }

        return match ($type->getName()) {
            PhoneNumber::class => new Guess\TypeGuess(PhoneNumberType::class, [
                'default_region' => $this->mapper->getRegion(),
                'format' => PhoneNumberFormat::NATIONAL,
            ], Guess\Guess::VERY_HIGH_CONFIDENCE),
            default => null,
        };
    }

    public function guessRequired(string $class, string $property): ?Guess\ValueGuess
    {
        $type = $this->getReflectionType($class, $property);

        if (!$type) {
            return null;
        }

        return new Guess\ValueGuess(!$type->allowsNull(), Guess\Guess::HIGH_CONFIDENCE);
    }

    public function guessMaxLength(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }

    public function guessPattern(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }

    private function getReflectionType(string $class, string $property): ?\ReflectionNamedType
    {
        if (!class_exists($class) || !property_exists($class, $property)) {
            return null;
        }
        $ref = new \ReflectionProperty($class, $property);
        $type = $ref->getType();

        if (!$type instanceof \ReflectionNamedType) {
            return null;
        }

        return $type;
    }
}