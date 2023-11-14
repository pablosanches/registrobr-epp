<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\BaseTesting;
use PabloSanches\RegistroBR\EppClient;

class ContactTest extends BaseTesting
{
    public function testCreate(): ?string
    {
        $eppClient = EppClient::factory('user', 'password');
        $contact = ResourceFactory::factory($eppClient, 'contact');
        $response = $contact->create([
            'name' => $this->faker->name(),
            'street_1' => 'Rua das Laranjeirass',
            'street_2' => '100',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zipcode' => '02127-000',
            'phone' => '+55.1122222222',
            'email' => 'testes@teste.com'
        ]);

        $result = $response->getResponse();
        self::assertNotEmpty($result['contact:creData']);
        return $result['contact:creData']['contact:id'];
    }

    /**
     * @depends testCreate
     */
    public function testInfo($id)
    {
        $eppClient = EppClient::factory('user', 'password');
        $contact = ResourceFactory::factory($eppClient, 'contact', ['id' => $id]);
        $response = $contact->info();
        $result = $response->getResponse();
        self::assertEquals($id, $result['contact:infData']['contact:id']);
    }
}