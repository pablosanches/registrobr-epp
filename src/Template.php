<?php

namespace PabloSanches\RegistroBR;

use PabloSanches\RegistroBR\Exception\RegistroBRException;

class Template implements TemplateInterface
{
    /**
     * @throws RegistroBRException
     */
    public function __construct(
        private string $xml,
        private array $context = []
    ) {
    }

    /**
     * @throws RegistroBRException
     */
    public function xml(): string
    {
        $templatePath = $this->templatePath($this->xml);
        $templateContent = file_get_contents($templatePath);
        return $this->parseXml($templateContent, $this->context);
    }

    private function parseXml(string $xml, array $context): string
    {
        return strtr($xml, $this->prepareContext($context));
    }

    private function prepareContext(array $context): array
    {
        $newContext = [];
        foreach ($context as $field => $value) {
            $newContext["{{ $field }}"] = $value;
        }

        $newContext['{{ clTRID }}'] = $this->getTemplateName() . '_' . uniqid('', true);

        $authInfo = <<<EOT
            <contact:authInfo>
                <contact:pw>YOURPASSWORD</contact:pw>
            </contact:authInfo>
        EOT;
        $newContext['{{ auth_info }}'] = $authInfo;

        return $newContext;
    }

    private function templatePath(string $xml): string
    {
        $templatePath = __DIR__ . "/../templates/{$xml}.xml";
        if (!file_exists($templatePath)) {
            throw new RegistroBRException("Não foi possível encontrar o template '{$templatePath}'");
        }

        return $templatePath;
    }

    public function getTemplateName(): string
    {
        $xml = explode('.', $this->xml);
        return current($xml);
    }
}
