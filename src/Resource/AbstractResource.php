<?php

namespace PabloSanches\RegistroBR\Resource;

abstract class AbstractResource implements ResourceInterface
{
    public function __construct(
        protected array $arguments = []
    ) {
    }
}