<?php

namespace PabloSanches\RegistroBR\Resource;

use PabloSanches\RegistroBR\BaseTesting;
use PabloSanches\RegistroBR\EppClient;
use PabloSanches\RegistroBR\Helper;

class DomainTest extends BaseTesting
{
    public function testCheck()
    {
        $eppClient = EppClient::factory('user', 'password');
        $domain = ResourceFactory::factory($eppClient, 'domain');

        $domainName = 'yoursite6.com.br';
        $response = $domain->check(['name' => $domainName]);
        $response = $response->getResponse();
        self::assertEquals($domainName, $response['domain:chkData']['domain:cd']['domain:name']);
    }

    public function testCreate()
    {
        $eppClient = EppClient::factory('user', 'password');
        $domain = ResourceFactory::factory($eppClient, 'domain');
        $response = $domain->create([
            'name' => 'pablosanchesasdasdasd.com.br',
            'period' => 1,
            'dns_1' => 'ns1.yoursite-idc.net',
            'dns_2' => 'ns2.yoursite-idc.net',
            'org_id' => '246.838.523-30',
            'auto_renew' => 0
        ]);

        self::assertNotEmpty($response);
    }

    public function testInfo()
    {
        $eppClient = EppClient::factory('user', 'password');
        $domain = ResourceFactory::factory($eppClient, 'domain');

        $domainName = 'yoursite6.com.br';
        $response = $domain->info(['name' => $domainName]);
        $response = $response->getResponse();
        self::assertEquals($domainName, $response['domain:infData']['domain:name']);
    }

    public function testUpdateDomain()
    {
        $eppClient = EppClient::factory('user', 'password');
        $domain = ResourceFactory::factory($eppClient, 'domain');

        $response = $domain->update([
            'name' => 'yoursite6.com.br',
            'period' => 1,
            'dns_1' => 'ns1.yoursite-idc.net',
            'dns_2' => 'ns2.yoursite-idc.net',
            'org_id' => '246.838.523-30',
            'auto_renew' => 0
        ]);
        $response = $response->getResponse();
        self::assertNotEmpty($response);
    }

    public function testDeleteDomain()
    {
        $eppClient = EppClient::factory('user', 'password');
        $domain = ResourceFactory::factory($eppClient, 'domain');

        $response = $domain->delete(['name' => 'yoursite6.com.br']);
        $response = $response->getResponse();
        self::assertNotEmpty($response);
    }
}