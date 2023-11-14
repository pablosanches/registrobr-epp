<?php

namespace PabloSanches\RegistroBR\DTO;

use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\Helper;

abstract class DTOFactory
{
    /**
     * @throws RegistroBRException
     */
    public static function factory(string $dtoName, array $arguments = []): DTOInterface
    {
        $dtoNamespace = Helper::buildNamespace($dtoName, 'DTO');
        return new $dtoNamespace($arguments);
    }
}