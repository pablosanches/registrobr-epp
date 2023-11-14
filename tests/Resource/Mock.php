<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\CommandFactory;
use PabloSanches\RegistroBR\EppClient;
use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\Template;
use PabloSanches\RegistroBR\TemplateInterface;

class Mock extends AbstractResource
{
    public function getClassName(): string
    {
        return parent::getClassName();
    }

    public function getTemplateNameByMethod(string $method): string
    {
        return parent::getTemplateNameByMethod($method);
    }

    /**
     * @throws RegistroBRException
     */
    public function factoryTemplateByMethodName(string $methodName, array $arguments): TemplateInterface
    {
        return new Template(
            $this->getTemplateNameByMethod($methodName),
            array_merge($this->arguments, $arguments)
        );
    }

    /**
     * @throws RegistroBRException
     */
    public function __call(string $method, array $arguments = [])
    {
        $template = $this->factoryTemplateByMethodName($method, $arguments);
        return CommandFactory::factory($this->eppClient, $template)->execute();
    }
}
