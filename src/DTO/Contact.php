<?php

namespace PabloSanches\RegistroBR\DTO;

class Contact
{
    public function __construct(
        public ?string $name,
        public ?string $street_1,
        public ?string $street_2,
        public ?string $city,
        public ?string $state,
        public ?string $zipcode,
        public ?string $phone,
        public ?string $email,
        public ?string $country = 'BR'
    ) {
    }
}