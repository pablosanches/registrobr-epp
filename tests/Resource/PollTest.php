<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\BaseTesting;
use PabloSanches\RegistroBR\EppClient;

class PollTest extends BaseTesting
{
    public function testRequest()
    {
        $eppClient = EppClient::factory('221', 'WLHHUIGTVL');
        $poll = ResourceFactory::factory($eppClient, 'poll');
        $response = $poll->request();
        $response = $response->getResponse();
        self::assertNotEmpty($response['result']['msg']);
        return $response;
    }

    /**
     * @depends testRequest
     */
    public function testDelete(mixed $response = null)
    {
        $eppClient = EppClient::factory('a', 'b');
        $poll = ResourceFactory::factory($eppClient, 'poll');

        $messageId = $response['msgQ_attr']['id'] ?? $response['msgQ_attr']['id'];
        $response = $poll->delete($messageId);
        $response = $response->getResponse();
        self::assertNotEmpty($response['result']['msg']);
    }
}