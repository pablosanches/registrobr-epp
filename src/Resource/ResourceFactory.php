<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\EppClient;
use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\Helper;

abstract class ResourceFactory
{

    /**
     * @param string $resourceName
     * @param array $arguments
     * @return ResourceInterface
     * @throws RegistroBRException
     */
    public static function factory(EppClient $eppClient, string $resourceName, array $arguments = []): ResourceInterface
    {
        $resourceNamespace = Helper::buildNamespace($resourceName, 'Resource');
        return new $resourceNamespace($eppClient, $arguments);
    }
}