<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\ResponseEpp;

class Poll extends AbstractResource
{
    public function request(array $parameters = []): ResponseEpp
    {
        $this->dto->operation = 'req';
        return $this->execute('request', $parameters);
    }

    public function delete(?string $messageId = null): ResponseEpp
    {
        $this->dto->operation = 'ack';
        return $this->execute('delete', ['message_id' => $messageId]);
    }

    private function execute(string $method, array $parameters = []): ResponseEpp
    {
        $this->dto->hydrate($parameters);
        return $this->executeCommand($method);
    }
}