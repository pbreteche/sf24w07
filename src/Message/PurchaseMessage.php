<?php

namespace App\Message;

use App\Entity\Purchase;
use libphonenumber\PhoneNumber;

class PurchaseMessage
{
    private PhoneNumber $phoneNumber;

    public function __construct(Purchase $purchase)
    {
        $this->phoneNumber = $purchase->getCustomerPhone();
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber->getNationalNumber();
    }
}
