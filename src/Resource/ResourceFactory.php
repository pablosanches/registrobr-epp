<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\Helper;

abstract class ResourceFactory
{
    /**
     * @throws RegistroBRException
     */
    public static function factoryByResourceName(string $resourceName, array $arguments): ResourceInterface
    {
        $resouceNamespace = Helper::buildResourceNamespaceFromResourceName($resourceName);
        return new $resouceNamespace($arguments);
    }
}