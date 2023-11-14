<?php

namespace PabloSanches\RegistroBR\DTO;

abstract class AbstractDTO implements DTOInterface
{
    public function __construct(array $arguments = [])
    {
        $this->hydrate($arguments);
    }

    public function hydrate(array $arguments): void
    {
        foreach ($arguments as $field => $value) {
            if (property_exists($this, $field)) {
                $this->{$field} = $value;
            }
        }
    }

    public function export(): array
    {
        $json = json_encode($this);
        return json_decode($json, true);
    }
}