<?php

namespace PabloSanches\RegistroBR;

use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\Resource\ResourceFactory;
use PabloSanches\RegistroBR\Resource\ResourceInterface;

final class RegistroBR
{
    protected function __construct(private EppClient $eppClient)
    {
    }

    /**
     * @throws RegistroBRException
     */
    public static function factory(string $user, string $pass): RegistroBR
    {
        return new static(EppClient::factory($user, $pass));
    }

    /**
     * @throws RegistroBRException
     */
    public function __call(string $resourceName, array $arguments): ResourceInterface
    {
        return ResourceFactory::factory($resourceName, $this->eppClient, $arguments);
    }
}
