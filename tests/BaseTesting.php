<?php

namespace PabloSanches\RegistroBR;

use PHPUnit\Framework\TestCase;

class BaseTesting extends TestCase
{
    protected \Faker\Generator $faker;

    public function __construct(string $name)
    {
        $this->faker = \Faker\Factory::create('pt_BR');
        parent::__construct($name);
    }
}