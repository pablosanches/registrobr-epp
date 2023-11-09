<?php

namespace PabloSanches\RegistroBR\DTO;

class Domain
{
    public function __construct(
        public ?string $name = null,
        public ?string $dns_1 = null,
        public ?string $dns_2 = null,
        public ?Organization $organization = null,
        public int $auto_renew = 0,
        public int $period = 1
    ) {
    }
}