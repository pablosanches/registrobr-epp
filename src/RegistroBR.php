<?php

namespace PabloSanches\RegistroBR;

final class RegistroBR
{
    protected function __construct(
        private EPP $epp
    ) {

    }

    public static function factory(string $user, string $pass): RegistroBR
    {
        $epp = new EPP($user, $pass);
        return new RegistroBR($epp);
    }
}