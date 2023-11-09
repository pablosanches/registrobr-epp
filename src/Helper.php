<?php

namespace PabloSanches\RegistroBR;

use PabloSanches\RegistroBR\Exception\RegistroBRException;

abstract class Helper
{
    /**
     * @throws RegistroBRException
     */
    public static function buildResourceNamespaceFromResourceName(string $resourceName): string
    {
        $resourceName = self::toCamelCase($resourceName);
        $resourceNamespace = __NAMESPACE__ . "\\Resource\\{$resourceName}";

        if (!class_exists($resourceNamespace)) {
            throw new RegistroBRException("Resource {$resourceNamespace} não foi existe.");
        }

        return $resourceNamespace;
    }

    public static function toCamelCase(string $string): string
    {
        $string = strtr($string, [
            ' ' => '##',
            '-' => '##',
            '_'
        ]);

        $stringParts = explode('##', $string);
        $stringParts = array_map(fn($string) => ucfirst($string), $stringParts);

        return implode('', $stringParts);
    }
}