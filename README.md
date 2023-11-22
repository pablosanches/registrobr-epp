# RegistroBR - EPP
Esta lib suporta as funções mais básicas do EPP criado pelo NIC.br e utilizadas no registrador do Registro.br

### Pré-requisito
É necessário ser uma empresa validada e cadastrada no Registro.br

### Contribua
Sinta-se livre para extender as funções disponibilizadas por esta lib.
[Documentação](http://registro.br/provedor/epp/pt-epp-accreditation-proc.html)

### Instalação
```sh
composer require pablosanches/registrobr-epp
```

### Utilização

#### Criando contato
```php
$eppClient = EppClient::factory('user', 'password');
$contact = ResourceFactory::factory($eppClient, 'contact');
$response = $contact->create([
    'name' => 'João da Silva',
    'street_1' => 'Rua das Laranjeiras',
    'street_2' => '100',
    'city' => 'São Paulo',
    'state' => 'SP',
    'zipcode' => '02127-000',
    'phone' => '+55.1122222222',
    'email' => 'teste@teste.com'
]);
var_dump($response);
```

#### Buscando informações de um contato
```php
$eppClient = EppClient::factory('user', 'password');
$contact = ResourceFactory::factory($eppClient, 'contact', ['id' => 'contact-id']);
$response = $contact->info();
var_dump($response);
```

#### Criando uma organização
```php
$eppClient = EppClient::factory('user', 'password');
$organization = ResourceFactory::factory($eppClient, 'organization');
$response = $organization->create([
    'id' => '246.838.523-30',
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
var_dump($response);
```

#### Buscando informações de uma organização
```php
$eppClient = EppClient::factory('user', 'password');
$organization = ResourceFactory::factory($eppClient, 'organization', ['id' => 'JOSIL44']);
$response = $organization->info();
var_dump($response);
```

#### Registrando um domínio
```php
$eppClient = EppClient::factory('user', 'password');
$domain = ResourceFactory::factory($eppClient, 'domain');
$response = $domain->create([
    'name' => 'dominiodeexemplo.com.br',
    'period' => 1,
    'dns_1' => 'ns1.yoursite-idc.net',
    'dns_2' => 'ns2.yoursite-idc.net',
    'org_id' => '246.838.523-30',
    'auto_renew' => 0
]);
var_dump($response);
```

#### Renovando um domínio
```php
$eppClient = EppClient::factory('user', 'password');
$domain = ResourceFactory::factory($eppClient, 'domain');
$response = $domain->renew([
    'name' => 'dominiodeexemplo.com.br',
    'current_expiration_date' => '2000-04-03',
    'period' => 1
]);
var_dump($response);
```
Obs: O parâmetro current_expiration_date é o domain:crDate de retorno do comando de domain_info.

#### Buscando informações de um domínio
```php
$eppClient = EppClient::factory('user', 'password');
$domain = ResourceFactory::factory($eppClient, 'domain');
$response = $domain->info(['name' => 'yoursite6.com.br']);
var_dump($response);
```

#### Verificando se um domínio está disponível
```php
$eppClient = EppClient::factory('user', 'password');
$domain = ResourceFactory::factory($eppClient, 'domain');
$response = $domain->check(['name' => 'yoursite6.com.br']);
var_dump($response);
```
