<?php

namespace PabloSanches\RegistroBR;

use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\Resource\Contact;

class HelperTest extends BaseTesting
{

    public static function toCamelCaseProvider(): array
    {
        return array(
            ['pablo-sanches'],
            ['PABLO-SANCHES'],
            ['pablo-SANCHES'],
            ['Pablo-Sanches'],
            ['pablo_sanches'],
            ['PABLO_SANCHES'],
            ['pablo_SANCHES'],
            ['Pablo_Sanches'],
            ['pablo sanches'],
            ['PABLO SANCHES'],
            ['pablo SANCHES'],
            ['Pablo Sanches'],
        );
    }

    /**
     * @dataProvider toCamelCaseProvider
     */
    public function testConvertendoStringParaCamelCase($string): void
    {
        self::assertEquals('PabloSanches', Helper::toCamelCase($string));
    }

    public function testBuildInvalidResourceMustThrowsException(): void
    {
        self::expectException(RegistroBRException::class);
        $invalidResource = Helper::buildNamespace('Invalid-Resource', 'Resource');
    }

    public function testBuildValidResourceMustReturnNamespace(): void
    {
        $contactResource = Helper::buildNamespace('contact', 'Resource');
        self::assertEquals(Contact::class, $contactResource);
    }
}