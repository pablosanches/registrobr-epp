<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\BaseTesting;
use PabloSanches\RegistroBR\EppClient;
use PabloSanches\RegistroBR\Helper;

class OrganizationTest extends BaseTesting
{
    public function testCreate(): ?string
    {
        $eppClient = EppClient::factory('user', 'password');
        $organization = ResourceFactory::factory($eppClient, 'organization');
        $response = $organization->create([
            'id' => $this->faker->cpf(),
            'name' => 'José da Silva',
            'street_1' => 'Rua das Figueiras',
            'street_2' => '200',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zipcode' => '01311-100',
            'country' => 'BR',
            'phone' => '+55.1133333333',
            'email' => 'teste@teste.com.br',
            'contact_admin_id' => 'JOSIL44',
            'contact_tech_id' => 'JOSIL44',
            'contact_billing_id' => 'JOSIL44',
            'contact_name' => 'José da Silva'
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
        $organization = ResourceFactory::factory($eppClient, 'organization', ['id' => $id]);
        $response = $organization->info();
        $result = $response->getResponse();
        self::assertEquals(Helper::onlyNumbers($id), Helper::onlyNumbers($result['contact:infData']['contact:id']));
    }
}