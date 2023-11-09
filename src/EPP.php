<?php

namespace PabloSanches\RegistroBR;

use http\Env\Response;

final class EPP
{
    private const CERTIFICATE = 'client.pem';
    private const HOST = 'beta.registro.br';
    private const PORT = 700;

    private static ?EPP $instance;
    private $conn;

    private function __construct(
        private string $user,
        private string $pass
    ) {
        $this->connect();
    }

    public static function factory($user, $pass): EPP
    {
        if (is_null(self::$instance)) {
            self::$instance = new EPP($user, $pass);
        }

        return self::$instance;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    public function connect(): resource|false
    {
        $streamContext = stream_context_create([
            'ssl' => [
                'allow_self_signed' => true,
                'local_cert' => self::CERTIFICATE
            ]
        ]);

        $errno = '';
        $errstr = '';
        $conn = stream_socket_client(
            sprintf("tls://%s:%s", self::HOST, self::PORT),
            $errno,
            $errstr,
            10,
            STREAM_CLIENT_CONNECT,
            $streamContext
        );

        if (!$conn) {
            return false;
        }

        return $this->unwrap();
    }

    public function disconnect(): void
    {
        $this->conn = null;
    }

    public function sendCommand(TemplateInterface $template): int|bool
    {
        return fwrite($this->conn, $template->xml());
    }

    public function login(): ResponseInterface
    {

    }

    public function logout(): ResponseInterface
    {

    }

    public function hello(): ResponseInterface
    {

    }

    private function unwrap(): ResponseInterface
    {
    }
}