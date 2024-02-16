<?php

namespace App\DataFixtures;

use App\Entity\Enum\TShirtSize;
use App\Entity\TShirt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TShirtFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $f = Factory::create();

        $t = new TShirt();
        $t
            ->setName($f->name())
            ->setColor($f->hexColor())
            ->setDescription($f->text())
            ->setPrice($f->numberBetween(20, 100))
            ->setReferenceNumber($f->regexify('[A-Z]{5}[0-4]{3}'))
            ->setCreatedAt(\DateTimeImmutable::createFromInterface($f->dateTime()))
            ->setSize($f->randomElement(TShirtSize::cases()))
        ;

        $manager->persist($t);
        $manager->flush();
    }
}
