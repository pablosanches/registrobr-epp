<?php

namespace PabloSanches\RegistroBR\DTO;

use PabloSanches\RegistroBR\BaseTesting;

class DTOTest extends BaseTesting
{
    public function testInitializeWithoutParameters()
    {
        $dto = new Mock();
        self::assertInstanceOf(Mock::class, $dto);
        $values = array_values($dto->export());
        $values = array_filter($values);
        self::assertEmpty($values);
    }

    public function testInitializeWithParameters(): void
    {
        $parameters = [
            'field1' => '1',
            'field2' => '2',
            'field3' => '3',
        ];
        $dto = new Mock($parameters);
        self::assertSame($parameters, $dto->export());
    }

    public function testHydrateDtoWithoutParameters(): void
    {
        $dto = new Mock();
        $values = array_values($dto->export());
        $values = array_filter($values);
        self::assertEmpty($values);

        $parameters = [
            'field1' => '1',
            'field2' => '2',
            'field3' => '3',
        ];
        $dto->hydrate($parameters);
        self::assertSame($parameters, $dto->export());
    }

    public function testHydrateDtoWithParameters(): void
    {
        $parameters = [
            'field1' => '1',
            'field2' => '2',
            'field3' => '3',
        ];
        $dto = new Mock($parameters);
        self::assertSame($parameters, $dto->export());

        $parameters = [
            'field1' => '4',
            'field2' => '5',
            'field3' => '6',
        ];
        $dto->hydrate($parameters);
        self::assertSame($parameters, $dto->export());
    }
}
