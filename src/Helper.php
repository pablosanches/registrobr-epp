<?php

/** @noinspection CallableParameterUseCaseInTypeContextInspection */

namespace PabloSanches\RegistroBR;

use PabloSanches\RegistroBR\Exception\RegistroBRException;

abstract class Helper
{
    /**
     * @throws RegistroBRException
     */
    public static function buildNamespace(string $className, string $type): string
    {
        $className = self::toCamelCase($className);
        $namespace = __NAMESPACE__ . "\\$type\\{$className}";
        if (!class_exists($namespace)) {
            throw new RegistroBRException("$type '$namespace' indisponível.");
        }

        return $namespace;
    }

    public static function toCamelCase(string $resourceName): string
    {
        $resourceName = strtr($resourceName, [
            '_' => '##',
            '-' => '##',
            ' ' => '##'
        ]);

        $resourceName = explode('##', $resourceName);
        $resourceName = array_map(static fn ($string) => mb_convert_case($string, MB_CASE_TITLE), $resourceName);
        return implode('', $resourceName);
    }

    public static function onlyNumbers(string $string): int
    {
        return (int) preg_replace('/[^0-9]/', '', $string);
    }
}
