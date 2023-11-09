<?php

namespace PabloSanches\RegistroBR\DTO;

class Organization
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $street_1 = null,
        public ?string $street_2 = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $zipcode = null,
        public ?string $phone = null,
        public ?string $email = null,
        public ?string $country = 'BR',
        public ?Contact $contact = null
    ) {
    }
}