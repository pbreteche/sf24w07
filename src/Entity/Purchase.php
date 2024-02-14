<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: PhoneNumberType::NAME, nullable: true)]
    private ?PhoneNumber $customerPhone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerPhone(): ?PhoneNumber
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone(?PhoneNumber $customerPhone): static
    {
        $this->customerPhone = $customerPhone;

        return $this;
    }
}
