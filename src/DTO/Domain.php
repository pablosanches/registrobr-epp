<?php

namespace PabloSanches\RegistroBR\DTO;

class Domain extends AbstractDTO
{
    public ?string $name;
    public int $period = 1;
    public ?string $dns_1;
    public ?string $dns_2;
    public ?string $org_id;
    public int $auto_renew = 0;
}
