<?php

namespace PabloSanches\RegistroBR\DTO;

interface DTOInterface
{
    public function hydrate(array $arguments): void;
    public function export(): array;
}