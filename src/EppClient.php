<?php

namespace PabloSanches\RegistroBR;

use JsonException;
use PabloSanches\RegistroBR\Exception\RegistroBRException;

class EppClient
{
    private mixed $socket = null;

    /**
     * @throws RegistroBRException
     */
    protected function __construct(
        private string $user,
        private string $password,
        private string $host = 'beta.registro.br',
        private int $port = 700,
        private string $protocol = 'tls'
    ) {
        $this->connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * @throws RegistroBRException
     */
    public static function factory(string $username, string $password): EppClient
    {
        return new static($username, $password);
    }

    /**
     * @throws RegistroBRException
     */
    public function connect(): void
    {
        $address = "{$this->protocol}://{$this->host}:{$this->port}";
        $this->socket = stream_socket_client(
            $address,
            $errorNumber,
            $errorString,
            30,
            STREAM_CLIENT_CONNECT,
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'local_cert' => __DIR__ . '/../certificates/client.pem'
                ]
            ])
        );

        if (!empty($errorString)) {
            throw new RegistroBRException("Erro ao conectar ao servidor: '{$errorString}'");
        }

        if (!$this->socket) {
            throw new RegistroBRException("Não foi possível conectar ao servidor '{$address}'");
        }
        $this->unwrap();

        $this->login();
    }

    /**
     * @throws RegistroBRException
     */
    public function unwrap(): ?string
    {
        if (feof($this->socket)) {
            throw new RegistroBRException('Não foi possível executar o comando');
        }

        $packetHeader = fread($this->socket, 4);
        if (empty($packetHeader)) {
            throw new RegistroBRException('Não foi possível encontrar o header do comando');
        }

        $unpacked = unpack('N', $packetHeader);
        return fread($this->socket, $unpacked[1] - 4);
    }

    public function wrap($xml = null): string
    {
        return pack('N', (strlen($xml) + 4)) . $xml;
    }

    public function disconnect(): void
    {
        if (!is_null($this->socket)) {
            $this->logout();
            fclose($this->socket);
            $this->socket = null;
        }
    }

    /**
     * @throws RegistroBRException
     */
    public function executeCommand(string $xml): ?string
    {
        $xml = $this->wrap($xml);
        if (fwrite($this->socket, $xml) === false) {
            throw new RegistroBRException('Não foi possível executar o comando');
        }

        return $this->unwrap();
    }

    /**
     * @throws RegistroBRException
     * @throws JsonException
     */
    public function login(): self
    {
        $template = new Template('login', [
            'username' => $this->user,
            'password' => $this->password
        ]);

        $this->executeCommand($template->xml());
        return $this;
    }

    /**
     * @throws RegistroBRException
     * @throws JsonException
     */
    public function logout(): self
    {
        $template = new Template('logout');
        $this->executeCommand($template->xml());
        return $this;
    }

    /**
     * @throws RegistroBRException
     * @throws JsonException
     */
    public function hello(): ResponseInterface
    {
        $template = new Template('hello');
        return $this->executeCommand($template->xml());
    }

    private function generateId(): string
    {
        return uniqid('', true);
    }
}
