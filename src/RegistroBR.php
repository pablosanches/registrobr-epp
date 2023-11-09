<?php

namespace PabloSanches\RegistroBR;

use http\Env\Response;
use PabloSanches\RegistroBR\Resource\ResourceFactory;
use PabloSanches\RegistroBR\Resource\ResourceInterface;

final class RegistroBR
{
    protected function __construct(
        private EPP $epp
    ) {

    }

    public static function factory(string $user, string $pass): RegistroBR
    {
        return new RegistroBR(EPP::factory($user, $pass));
    }

    public function __call(string $resourceName, array $arguments): ResourceInterface
    {
        return ResourceFactory::factoryByResourceName($resourceName, $arguments);
    }
}