<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\BaseTesting;
use PabloSanches\RegistroBR\EppClient;
use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\TemplateInterface;

class ResourceTest extends BaseTesting
{
    /**
     * @throws RegistroBRException
     */
    public function getResourceMock(): Mock
    {
        return new Mock(
            EppClient::factory('user', 'pass'),
            []
        );
    }

    /**
     * @throws RegistroBRException
     */
    public function testGetClassName(): void
    {
        $resourceMock = $this->getResourceMock();
        self::assertEquals('mock', $resourceMock->getClassName());
    }

    /**
     * @throws RegistroBRException
     */
    public function testGetTemplateNameByMethod(): void
    {
        $resourceMock = $this->getResourceMock();
        self::assertEquals('mock_info', $resourceMock->getTemplateNameByMethod('info'));
    }

    /**
     * @throws RegistroBRException
     */
    public function testFactoryTemplateByMethodName(): void
    {
        $resourceMock = $this->getResourceMock();
        $template = $resourceMock->factoryTemplateByMethodName('info', []);
        self::assertInstanceOf(TemplateInterface::class, $template);
        self::assertEquals('mock_info', $template->getTemplateName());
    }
}