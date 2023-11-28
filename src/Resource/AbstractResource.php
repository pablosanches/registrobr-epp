<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\CommandFactory;
use PabloSanches\RegistroBR\DTO\DTOFactory;
use PabloSanches\RegistroBR\DTO\DTOInterface;
use PabloSanches\RegistroBR\EppClient;
use PabloSanches\RegistroBR\Exception\RegistroBRException;
use PabloSanches\RegistroBR\ResponseEpp;
use PabloSanches\RegistroBR\ResponseInterface;
use PabloSanches\RegistroBR\Template;

abstract class AbstractResource implements ResourceInterface
{
    protected DTOInterface $dto;

    /**
     * @throws RegistroBRException
     */
    public function __construct(
        protected EppClient $eppClient,
        protected array $arguments = []
    ) {
        $this->dto = DTOFactory::factory($this->getClassName(), $this->arguments);
    }

    protected function getClassName(): string
    {
        $class = get_class($this);
        $class = explode('\\', $class);
        return mb_strtolower(end($class));
    }

    protected function getTemplateNameByMethod(string $method = ''): string
    {
        if (!empty($method)) {
            $method = "_{$method}";
        }

        return $this->getClassName() . $method;
    }

    /**
     * @throws RegistroBRException
     */
    public function __call(string $method, array $arguments = []): ResponseEpp
    {
        if (!empty($arguments)) {
            $this->dto->hydrate(...$arguments);
        }
        return $this->executeCommand($method);
    }

    /**
     * @throws RegistroBRException
     */
    public function executeCommand(string $method = ''): ResponseEpp
    {
        $template = new Template(
            $this->getTemplateNameByMethod($method),
            $this->dto->export()
        );

        $answer = CommandFactory::factory($this->eppClient, $template)->execute();
        return new ResponseEpp($answer);
    }
}