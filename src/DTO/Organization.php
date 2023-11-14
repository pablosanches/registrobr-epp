<?php

namespace PabloSanches\RegistroBR\DTO;

class Organization extends AbstractDTO
{
    public ?string $id;
    public ?string $name;
    public ?string $street_1;
    public ?string $street_2;
    public ?string $city;
    public ?string $state;
    public ?string $zipcode;
    public ?string $country = 'BR';
    public ?string $phone;
    public ?string $email;
    public ?string $contact_admin_id;
    public ?string $contact_tech_id;
    public ?string $contact_billing_id;
    public ?string $contact_name;
}
